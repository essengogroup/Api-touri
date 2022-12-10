<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Departement;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::factory()->create([
            'full_name' => 'super admin',
            'email' => 'super@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        User::factory(10)->create();
        $departementDatas = json_decode(file_get_contents(storage_path('mocks') . '/departements.json'), true);
        $siteDatas = json_decode(file_get_contents(storage_path('mocks') . '/sites.json'), true);
        collect($departementDatas)->each(function ($departementData) use ($siteDatas) {
            $departement = Departement::create([
                'name' => $departementData['name'],
                'description' => Factory::create()->text(200),
                'image_path' => Factory::create()->imageUrl(640, 480, 'paris', true),
            ]);
            $departement->sites()->createMany(
                collect($siteDatas)->filter(function ($siteData) use ($departementData) {
                    return $siteData['departement'] === $departementData['name'];
                })->map(function ($siteData) {
                    return [
                        'name' => $siteData['name'],
                        'description' => $siteData['description'],
                        'price' => Factory::create()->numberBetween(10, 100),
                        'latitude' => Factory::create()->latitude,
                        'longitude' => Factory::create()->longitude,
                    ];
                })->toArray()
            );
        });
    }
}

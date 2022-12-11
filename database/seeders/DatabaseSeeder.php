<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activite;
use App\Models\Departement;
use App\Models\Site;
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
        $departementDatas = json_decode(file_get_contents(storage_path('mocks') . '/departements.json'), true);
        $siteDatas = json_decode(file_get_contents(storage_path('mocks') . '/sites.json'), true);


        User::factory()->create([
            'full_name' => 'super admin',
            'email' => 'super@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        User::factory(10)->create();


        collect($departementDatas)->each(function ($departementData) use ($siteDatas) {
            $departement = Departement::create([
                'name' => $departementData['name'],
                'description' => Factory::create()->text(200),
                'image_path' => Factory::create()->imageUrl(640, 480, 'paris', true),
            ]);
            $site = $departement->sites()->createMany(
                collect($siteDatas)->filter(function ($siteData) use ($departementData) {
                    return $siteData['departement'] === $departementData['name'];
                })->map(function ($siteData) {
                    return [
                        'name' => $siteData['name'],
                        'description' => $siteData['description'],
                        'price' =>
                        Factory::create()->numberBetween(10, 100),
                        'latitude' => Factory::create()->latitude,
                        'longitude' => Factory::create()->longitude,
                    ];
                })->toArray()
            );
        });

        $sites = Site::all();
        $sites->map(function ($site) {
            $site->medias()->createMany(
                collect(range(1, 5))->map(function () {
                    return [
                        'name' => Factory::create()->name,
                        'path' => Factory::create()->imageUrl(640, 480, 'cat', true),
                    ];
                })->toArray()
            );

            $site->siteDates()->createMany(
                collect(range(1, 5))->map(function () {
                    return [
                        'date_' => Factory::create()->dateTimeBetween('now', '+1 day'),
                        'start_time' => Factory::create()->time('H:i'),
                        'end_time' => Factory::create()->time('H:i'),
                    ];
                })->toArray()
            );
        });
        Activite::factory(10)->create();
    }
}

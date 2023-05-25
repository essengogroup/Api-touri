<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Constants\RoleConstants;
use App\Models\Departement;
use App\Models\Media;
use App\Models\Site;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);

        $admin = User::factory()->create([
            'email' => 'super@admin.com',
        ]);
        $admin->assignRole(RoleConstants::ADMIN);

        $clients = User::factory(10)->create();
        $clients->each(function ($client) {
            $client->assignRole(RoleConstants::CLIENT);
        });
        $departementDatas = json_decode(file_get_contents(storage_path('mocks') . '/departements.json'), true);
        $siteDatas = json_decode(file_get_contents(storage_path('mocks') . '/sites.json'), true);
        /*$departements = Departement::factory()->create([
            'name' => $departementDatas['name'],
            'description' => Factory::create()->text(200),
            'image_path' => Factory::create()->imageUrl(640, 480, 'paris', true),
        ]);*/
        $departements = collect($departementDatas)
            ->map(function ($departementData) {
                Departement::factory()->create([
                    'name' => $departementData['name'],
                    'description' => Factory::create()->text(200)
                ]);
            });
        Departement::all()->each(function ($departement) use ($siteDatas) {
            $departement->sites()->createMany(
                collect($siteDatas)->filter(function ($siteData) use ($departement) {
                    return $siteData['departement'] === $departement->name;
                })->map(function ($siteData) {
                    return [
                        'name' => $siteData['name'],
                        'description' => $siteData['description'],
                        'price' =>
                            Factory::create()->numberBetween(1000, 100000),
                        'latitude' => Factory::create()->latitude,
                        'longitude' => Factory::create()->longitude,
                    ];
                })->toArray()
            );

            /*$departement->sites()->createMany(
                Site::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create([
                    'departement_id' => $departement->id,
                ])->make()->toArray()
            );*/
        });

        Site::all()->each(function ($site) {
            $site->medias()->createMany(
                Media::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create([
                    'site_id' => $site->id,
                ])->make()->toArray()
            );
        });


        /*         $departementDatas = json_decode(file_get_contents(storage_path('mocks') . '/departements.json'), true);
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
            $departement->sites()->createMany(
                collect($siteDatas)->filter(function ($siteData) use ($departementData) {
                    return $siteData['departement'] === $departementData['name'];
                })->map(function ($siteData) {
                    return [
                        'name' => $siteData['name'],
                        'description' => $siteData['description'],
                        'price' =>
                        Factory::create()->numberBetween(1000, 100000),
                        'latitude' => Factory::create()->latitude,
                        'longitude' => Factory::create()->longitude,
                    ];
                })->toArray()
            );
        });

        $activites = Activite::factory(10)->create();

        $sites = Site::all();
        $sites->map(function ($site) use ($activites) {
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
            $site->activites()->attach(
                $activites->random(5)->map(function ($activite) {
                    return [
                        'activite_id' => $activite->id,
                        'type' => Factory::create()->randomElement(['optionnel', 'obligatoire']),
                        'price' => Factory::create()->numberBetween(1000, 100000),
                    ];
                })->toArray()
            );
        });

        $reservations = \App\Models\ReservationSite::factory(10)->create();
 */
    }
}

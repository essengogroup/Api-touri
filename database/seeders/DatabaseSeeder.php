<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Constants\RoleConstants;
use App\Models\Activite;
use App\Models\Assurance;
use App\Models\Comment;
use App\Models\Departement;
use App\Models\Guide;
use App\Models\Hebergement;
use App\Models\Like;
use App\Models\Media;
use App\Models\MediaActivite;
use App\Models\Restaurant;
use App\Models\Share;
use App\Models\Site;
use App\Models\Transport;
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
    public function run(): void
    {
        $departementDatas = json_decode(file_get_contents(storage_path('mocks') . '/departements.json'), true);
        $siteDatas = json_decode(file_get_contents(storage_path('mocks') . '/sites.json'), true);

        $this->call(RolesTableSeeder::class);

        $admin = User::factory()->create([
            'email' => 'super@admin.com',
        ]);
        $admin->assignRole(RoleConstants::ADMIN);

        $clients = User::factory(10)->create();
        $clients->each(function ($client) {
            $client->assignRole(RoleConstants::CLIENT);
        });


        collect($departementDatas)
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
        });

        Site::query()->limit(10)->get()->each(function ($site) {
            $site->medias()->createMany(
                Media::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create([
                    'site_id' => $site->id,
                ])->make()->toArray()
            );
            $site->comments()->createMany(
                Comment::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create([
                    'commentable_id' => $site->id,
                    'commentable_type' => Site::class,
                ])->make()->toArray()
            );
            $site->likes()->createMany(
                Like::factory(
                    Factory::create()->numberBetween(4, 100)
                )->create([
                    'likeable_id' => $site->id,
                    'likeable_type' => Site::class,
                ])->make()->toArray()
            );
            $site->shares()->createMany(
                Share::factory(
                    Factory::create()->numberBetween(4, 100)
                )->create([
                    'shareable_id' => $site->id,
                    'shareable_type' => Site::class,
                ])->make()->toArray()
            );

            $site->guides()->attach(
                Guide::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create()->pluck('id')
            );
            $site->assurances()->attach(
                Assurance::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create()->pluck('id')
            );
            $site->restaurants()->attach(
                Restaurant::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create()->pluck('id')
            );
            $site->hebergements()->attach(
                Hebergement::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create()->pluck('id')
            );
            $site->transports()->attach(
                Transport::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create()->pluck('id')
            );
            $site->restaurants()->attach(
                Restaurant::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create()->pluck('id')
            );
            $site->activites()->attach(
                Activite::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create()->pluck('id')
            );
        });

        Activite::query()->get()->each(function ($activite) {
            $activite->mediaActivites()->createMany(
                MediaActivite::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create([
                    'activite_id' => $activite->id,
                ])->make()->toArray()
            );
        });
    }
}

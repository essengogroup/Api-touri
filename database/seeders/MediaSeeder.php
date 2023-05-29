<?php

namespace Database\Seeders;

use App\Models\Activite;
use App\Models\Assurance;
use App\Models\Comment;
use App\Models\Guide;
use App\Models\Hebergement;
use App\Models\Like;
use App\Models\Media;
use App\Models\Restaurant;
use App\Models\Share;
use App\Models\Site;
use App\Models\Transport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /*Site::all()->each(function ($site) {
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
            $site->activites()->attach(
                Activite::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create()->pluck('id')
            );
        });*/

        $sites = Site::all();
        foreach ($sites as $site) {
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
            $site->activites()->attach(
                Activite::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create()->pluck('id')
            );
        }
    }
}

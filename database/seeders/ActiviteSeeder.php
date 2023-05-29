<?php

namespace Database\Seeders;

use App\Models\Activite;
use App\Models\MediaActivite;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActiviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $batchSize = 100; // Nombre d'activités à traiter par lot

        $activiteCount = Activite::count();
        $pageCount = ceil($activiteCount / $batchSize);

        for ($page = 1; $page <= $pageCount; $page++) {
            Activite::skip(($page - 1) * $batchSize)
                ->take($batchSize)
                ->get()
                ->each(function ($activite) {
                    $activite->mediaActivites()->createMany(
                        MediaActivite::factory(
                            Factory::create()->numberBetween(1, 5)
                        )->create([
                            'activite_id' => $activite->id,
                        ])->make()->toArray()
                    );
                });
        }


        /*Activite::all()->each(function ($activite) {
            $activite->mediaActivites()->createMany(
                MediaActivite::factory(
                    Factory::create()->numberBetween(1, 5)
                )->create([
                    'activite_id' => $activite->id,
                ])->make()->toArray()
            );
        });*/
    }
}

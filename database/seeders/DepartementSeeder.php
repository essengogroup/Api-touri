<?php

namespace Database\Seeders;

use App\Models\Departement;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $departementDatas = [
            ["name" => "Brazzaville"],
            ["name" => "Cuvette"],
            ["name" => "Cuvette-Ouest"],
            ["name" => "Kouilou"],
            ["name" => "Lekoumou"],
            ["name" => "Likouala"],
            ["name" => "Niari"],
            ["name" => "Plateaux"],
            ["name" => "Pool"],
            ["name" => "Sangha"],
            ["name" => "Bouenza"],
        ];

        foreach ($departementDatas as $departementData) {
            Departement::factory()->create([
                'name' => $departementData['name'],
                'description' => Factory::create()->text(200)
            ]);
        }
    }
}

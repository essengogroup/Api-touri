<?php

namespace Database\Seeders;

use App\Constants\RoleConstants;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $admin = User::factory()->create([
            'email' => 'super@admin.com',
        ]);
        $admin->assignRole(RoleConstants::ADMIN);

        $clients = User::factory(10)->create();
        $clients->each(function ($client) {
            $client->assignRole(RoleConstants::CLIENT);
        });
    }
}

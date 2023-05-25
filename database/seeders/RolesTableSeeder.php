<?php

namespace Database\Seeders;

use App\Constants\RoleConstants;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => RoleConstants::ADMIN]);
        Role::create(['name' => RoleConstants::CLIENT]);
    }
}

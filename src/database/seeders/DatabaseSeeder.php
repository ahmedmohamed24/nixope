<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // create the main roles specified by the business requirements
        Role::query()->firstOrCreate(['name' => 'admin'], []);
        Role::query()->firstOrCreate(['name' => 'staff'], []);
        Role::query()->firstOrCreate(['name' => 'customer'], []);
    }
}

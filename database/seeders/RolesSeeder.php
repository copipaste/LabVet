<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'cliente']);
        Role::firstOrCreate(['name' => 'secretaria']);
        Role::firstOrCreate(['name' => 'bioquimico']);
        Role::firstOrCreate(['name' => 'administrador']);
    }
}

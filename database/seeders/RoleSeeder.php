<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'customer'
        ]);

        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Devan Cell',
            'email' => 'devanherdiansyah74@gmail.com',
            'password' => 123456
        ])->assignRole('admin');
    }
}
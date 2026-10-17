<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $juriRole  = Role::where('name', 'juri')->first();

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Administrator',
                'phone'    => '081234567890',
                'password' => Hash::make('password'),
                'role_id'  => $adminRole->id,
            ]
        );

        // Juri
        User::firstOrCreate(
            ['email' => 'juri@example.com'],
            [
                'name'     => 'Juri Utama',
                'phone'    => '081298765432',
                'password' => Hash::make('password'),
                'role_id'  => $juriRole->id,
            ]
        );
    }
}
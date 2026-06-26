<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a superadmin user
        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@elangwater.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // Change this in production!
            ]
        );

        // Assign the superadmin role
        $superadmin->assignRole('superadmin');

        // Create an admin-toko user
        $admin = User::updateOrCreate(
            ['email' => 'admin@elangwater.com'],
            [
                'name' => 'Admin Toko',
                'password' => Hash::make('password'),
            ]
        );

        // Assign the admin-toko role
        $admin->assignRole('admin-toko');

        // Create a kasir user
        $kasir = User::updateOrCreate(
            ['email' => 'kasir@elangwater.com'],
            [
                'name' => 'Kasir',
                'password' => Hash::make('password'),
            ]
        );

        // Assign the kasir role
        $kasir->assignRole('kasir');
    }
}
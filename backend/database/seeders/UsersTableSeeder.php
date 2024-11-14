<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Customer',
            'email' => 'customer@carrental.com',
            'password' => 'password',
            'role' => 'customer',
        ]);
        User::create([
            'name' => 'Mechanic',
            'email' => 'mechanic@carrental.com',
            'password' => 'password',
            'role' => 'mechanic',
        ]);
        User::create([
            'name' => 'Salesman',
            'email' => 'salesman@carrental.com',
            'password' => 'password',
            'role' => 'salesman',
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@carrental.com',
            'password' => 'password',
            'role' => 'admin',
        ]);
    }
}

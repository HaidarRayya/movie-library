<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // admin account
        User::create([
            'first_name' => 'haidar',
            'last_name' => 'rayya',
            'email' => 'admin@gmail.com',
            'role' => 0,
            'password' => Hash::make('admin12341234_'),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin SummitBuddy',
            'email' => 'admin@summitbuddy.com',
            'password' => Hash::make('password'),
        ]);
    }
}

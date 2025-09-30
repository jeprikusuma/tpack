<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@admin.com',
            'num' => 123123,
            'password' => Hash::make('dosen@2025'),
            'role' => 'dosen'
        ]);
    }
}

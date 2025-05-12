<?php

namespace Database\Seeders;

use App\Models\Resource;
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

        // delete all from Resource
        Resource::truncate();
        User::truncate();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory()->create([
            'name' => 'adham',
            'email' => 'adhmalslahy@gmail.com',
            'password'=> Hash::make('adhm1234'),
        ]);
    }
}

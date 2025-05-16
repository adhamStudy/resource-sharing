<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔐 Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // ✅ Clean tables using delete (respects foreign keys)
        DB::table('reservations')->delete();
        DB::table('resources')->delete();
        DB::table('posts')->delete();
        DB::table('users')->delete();

        // ✅ Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // 🌱 Seed test users
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'adham',
            'email' => 'adhmalslahy@gmail.com',
            'password' => Hash::make('adhm1234'),
        ]);
    }
}

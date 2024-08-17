<?php

namespace Database\Seeders;

use App\Models\System;
use App\Models\User;
use App\Models\UserSystem;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::create([
        //     'username' => 'adminadmin',
        //     'password' => Hash::make('admin'),
        //     'name' => 'Mansour',
        //     'role' => 'مدير'
        // ]);
        User::where('username', 'adminadmin')->update(['role' => 'مدير أعلى']);
        System::create([
            'name' => 'archive',
        ]);
        System::create([
            'name' => 'fouls',
        ]);
        UserSystem::create([
            'user_id' => User::where('username', 'adminadmin')->first()->id,
            'system_id' => 1,
        ]);
        UserSystem::create([
            'user_id' => User::where('username', 'adminadmin')->first()->id,
            'system_id' => 2,
        ]);
    }
}

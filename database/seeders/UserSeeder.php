<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('users')->where('email', 'admin@fuxi.com')->exists()) {
            return;
        }

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@fuxi.com',
            'password' => Hash::make('fuxi123@'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

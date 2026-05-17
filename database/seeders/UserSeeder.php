<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('users')->where('email', 'admin@admin.com')->exists()) {
            return;
        }

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

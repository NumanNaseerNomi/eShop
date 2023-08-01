<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                [
                    'name' => 'Admin',
                    'address' => 'Admin Address',
                    'email' => 'admin@admin.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('admin@admin.com'),
                    'is_admin' => true,
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}

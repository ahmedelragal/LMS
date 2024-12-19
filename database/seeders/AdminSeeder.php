<?php

namespace Database\Seeders;

use App\Models\Admin;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456789'), 
            'role' => 'super_admin',
            'school_id' => null 
        ]);

        // Create a School Admin
        Admin::create([
            'name' => 'School Admin',
            'email' => 'school@admin.com',
            'password' => Hash::make('123456789'),
            'role' => 'school_admin',
            'school_id' => 1 
        ]);
    }
}

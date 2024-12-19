<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create([
            'name' => 'International High School',
            'is_active' => 1,
            'address' => 'Zezinia',
            'city' => 'Cairo',
        ]);

        School::create([
            'name' => 'National Secondary School',
            'is_active' => 1,
            'address' => 'Zezinia',
            'city' => 'Alexandria',
        ]);
    }
}

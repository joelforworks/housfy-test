<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Planet;

class PlanetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Planet::create([
            'name' => 'Earth',
            'width' => 20,
            'height' => 20,
        ]);
        
        Planet::create([
            'name' => 'Mars',
            'width' => 15,
            'height' => 15,
        ]);
    }
}

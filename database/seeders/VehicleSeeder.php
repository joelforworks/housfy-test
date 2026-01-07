<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create([
            'name' => 'Sputnik 2',
            'planet_id' => 2,
            'team_id' => 2,
        ]);
        Vehicle::create([
            'name' => 'Mir',
            'planet_id' => 1,
            'team_id' => 2,
        ]);
        Vehicle::create([
            'name' => 'Curiosity Rover',
            'planet_id' => 2,
            'team_id' => 1,
        ]);
        Vehicle::create([
            'name' => 'Voyager 1',
            'planet_id' => 1,
            'team_id' => 1,
        ]);
    }
}

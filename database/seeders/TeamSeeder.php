<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'name' => 'Team United States',
        ]);
        
        Team::create([
            'name' => 'Team Soviet Union',
        ]);
    }
}

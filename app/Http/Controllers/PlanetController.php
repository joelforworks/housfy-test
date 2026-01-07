<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use App\Models\Team;
use App\Models\Vehicle;
use Inertia\Inertia;

class PlanetController extends Controller
{
    public function index()
    {
        $planets = Planet::all();
        $teams = Team::all();
        $vehicles = Vehicle::all();
        return Inertia::render('Home/Index', [
            'planets' => $planets,
            'teams' => $teams,
            'vehicles' => $vehicles
        ]);
    }
}

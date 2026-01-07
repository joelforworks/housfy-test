<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Planet;
use App\Utils\VehicleUtil;

class LogController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'command' => 'required|array',
            'command.*' => 'in:F,L,R',
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'obstacles' => 'required|array',
        ]);

        $vehicle = Vehicle::find($request->vehicle_id);
        $commands = $request->command;
        $obstacles = $request->obstacles;

        VehicleUtil::calculateNewPositionAndRegisterLog($vehicle,$commands,$obstacles);
        
        return response()->json([
            'success' => true,
            'message' => 'Log created successfully',
            'data' => ['vehicle'=>$vehicle,'logs'=>$vehicle->logs()->orderBy('created_at', 'desc')->get()]
        ], 201);
    }

    public function logs(Vehicle $vehicle){
        return response()->json($vehicle->logs()->orderBy('created_at', 'desc')->get());
    }
    public function generateObstacles(Planet $planet){
        $vehicles = $planet->vehicles()->get();
        $obstaclePositions = [];
        $positionsToAvoid=[];


        // vehicle coordinates
        foreach ($vehicles as $vehicle) {
            $positionsToAvoid[$vehicle['position_x'] . '_' . $vehicle['position_y']] = true;
        }

        for($i=0;$i<20;$i++){
            $randomObstacleX = rand(0, $planet->width - 1);
            $randomObstacleY = rand(0, $planet->height - 1);
            if(isset($positionsToAvoid[$randomObstacleY."_".$randomObstacleX]))continue;
            $obstaclePositions[] = [$randomObstacleX, $randomObstacleY];
            $positionsToAvoid[$randomObstacleY."_".$randomObstacleX]=true;
        }
 
        return $obstaclePositions;
    }

    
}

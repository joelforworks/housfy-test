<?php

namespace App\Utils;

use App\Models\Log;

class VehicleUtil
{
    public static function calculateNewPositionAndRegisterLog(
        $vehicle,
        array $commands,
        array $obstacles
    ) {
        $directions = ['N', 'E', 'S', 'W'];
        $planet = $vehicle->planet;
        $success = true;

        foreach ($commands as $cmd) {
            switch ($cmd) {
                case 'F':
                    $nextX = $vehicle->position_x;
                    $nextY = $vehicle->position_y;

                    switch ($vehicle->direction) {
                        case 'N':
                            $nextY = ($nextY + 1 + $planet->height) % $planet->height;
                            break;
                        case 'E':
                            $nextX = ($nextX + 1 + $planet->width) % $planet->width;
                            break;
                        case 'S':
                            $nextY = ($nextY - 1 + $planet->height) % $planet->height;
                            break;
                        case 'W':
                            $nextX = ($nextX - 1 + $planet->width) % $planet->width;
                            break;
                    }

                    if (self::isObstacle($nextX, $nextY, $obstacles)) {
                        $success = false;
                        break 2;
                    }

                    $vehicle->position_x = $nextX;
                    $vehicle->position_y = $nextY;
                    break;

                case 'L':
                    $index = array_search($vehicle->direction, $directions);
                    $vehicle->direction = $directions[($index + 3) % 4];
                    break;

                case 'R':
                    $index = array_search($vehicle->direction, $directions);
                    $vehicle->direction = $directions[($index + 1) % 4];
                    break;
            }
        }

        $vehicle->save();

        self::registerLog($vehicle, $commands, $success);
    }

    private static function isObstacle(int $x, int $y, array $obstacles): bool
    {
        foreach ($obstacles as $obstacle) {
            if ($obstacle[0] === $x && $obstacle[1] === $y) {
                return true;
            }
        }
        return false;
    }

    private static function registerLog($vehicle, array $commands,$success): void
    {
        Log::create([
            'command'    => implode('', $commands),
            'position_x' => $vehicle->position_x,
            'position_y' => $vehicle->position_y,
            'direction'  => $vehicle->direction,
            'vehicle_id' => $vehicle->id,
            'success' => $success,
        ]);
    }
}

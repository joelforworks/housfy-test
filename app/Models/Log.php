<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Vehicle;
use App\Models\Team;

class Log extends Model
{
    protected $fillable = [
        'command',
        'vehicle_id',
        'position_x',
        'position_y',
        'direction',
        'success',
    ];
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function Vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}

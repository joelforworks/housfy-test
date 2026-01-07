<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Planet;
use App\Models\Team;
use App\Models\Log;

class Vehicle extends Model
{
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function planet(): BelongsTo
    {
        return $this->belongsTo(Planet::class);
    }
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }
}

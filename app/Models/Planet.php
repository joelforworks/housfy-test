<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Vehicle;

class Planet extends Model
{

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
    
}

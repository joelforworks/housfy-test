<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Log;

class Team extends Model
{
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{


    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function timeSheets(): HasMany
    {
        return $this->hasMany(TimeSheet::class);
    }
}

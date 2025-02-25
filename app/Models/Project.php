<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function timeSheets(): HasMany
    {
        return $this->hasMany(TimeSheet::class);
    }

    public function attributeValues(): MorphMany
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }
}


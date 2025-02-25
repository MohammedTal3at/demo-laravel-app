<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class AttributeValue extends Model
{
    protected $fillable = ['attribute_id', 'entity_id', 'entity_type', 'value'];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function entity(): MorphTo
    {
        return $this->morphTo();
    }
}


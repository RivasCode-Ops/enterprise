<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    protected $fillable = [
        'property_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'message',
        'consent_privacy_accepted',
        'consent_accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'consent_privacy_accepted' => 'boolean',
            'consent_accepted_at' => 'datetime',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }
}

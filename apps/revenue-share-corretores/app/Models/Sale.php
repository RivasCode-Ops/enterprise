<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'lead_id',
        'sale_value',
        'split_percent',
        'revenue_broker',
    ];

    protected function casts(): array
    {
        return [
            'sale_value' => 'decimal:2',
            'split_percent' => 'decimal:2',
            'revenue_broker' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Sale $sale): void {
            $sale->revenue_broker = round(
                (float) $sale->sale_value * (float) $sale->split_percent / 100,
                2
            );
        });
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Property extends Model
{
    protected $fillable = [
        'broker_id',
        'slug',
        'title',
        'description',
        'price',
        'city',
        'state',
        'address_line',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Property $property): void {
            if (empty($property->slug)) {
                $property->slug = 'tmp-' . bin2hex(random_bytes(8));
            }
        });

        static::created(function (Property $property): void {
            $base = Str::slug(Str::limit((string) $property->title, 96, ''));
            if ($base === '') {
                $base = 'imovel';
            }
            $property->slug = $base . '-' . $property->getKey();
            $property->saveQuietly();
        });

        static::updating(function (Property $property): void {
            if ($property->isDirty('title')) {
                $base = Str::slug(Str::limit((string) $property->title, 96, ''));
                if ($base === '') {
                    $base = 'imovel';
                }
                $property->slug = $base . '-' . $property->getKey();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null): ?Property
    {
        $field = $field ?: $this->getRouteKeyName();

        return static::query()
            ->where($field, $value)
            ->where('status', 'published')
            ->firstOrFail();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function broker(): BelongsTo
    {
        return $this->belongsTo(Broker::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}

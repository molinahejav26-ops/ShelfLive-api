<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'purchase_price',
        'estimated_value',
        'acquired_at',
        'state',
        'format',
        'location',
        'notes',
        'user_id',
        'product_id',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'estimated_value' => 'decimal:2',
            'acquired_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}

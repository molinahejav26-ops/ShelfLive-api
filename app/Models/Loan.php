<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
        'borrower_name',
        'loaned_at',
        'due_at',
        'returned_at',
        'item_id',
    ];

    protected function casts(): array
    {
        return [
            'loaned_at' => 'date',
            'due_at' => 'date',
            'returned_at' => 'date',
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}

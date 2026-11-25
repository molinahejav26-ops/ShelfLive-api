<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => $this->product->title,
            'user' => $this->user->name,
            'state' => $this->state,
            'price' => $this->purchase_price === null ? null : (float) $this->purchase_price,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'estimated_value' => $this->estimated_value === null ? null : (float) $this->estimated_value,
            'format' => $this->format,
            'location' => $this->location,
            'notes' => $this->notes,
            'acquired_at' => $this->acquired_at?->toDateString(),
        ];
    }
}

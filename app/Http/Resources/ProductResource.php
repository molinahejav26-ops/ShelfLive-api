<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'barcode' => $this->barcode,
            'title' => $this->title,
            'platform' => $this->platform,
            'category' => $this->category->name,
            'author_publisher' => $this->author_publisher,
            'release_year' => $this->release_year,
            'cover_url' => $this->cover_url,
            'source' => $this->source,
            'status' => $this->status,
        ];
    }
}

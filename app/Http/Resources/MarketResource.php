<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image ? asset($this->image) : null,
            'image_alt' => $this->image_alt,
            'name' => $this->getNameAttribute(),
            'status' => (bool) $this->status,
           
        ];
    }
} 
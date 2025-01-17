<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => asset($this->image),
            'image_alt' => $this->image_alt,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
} 
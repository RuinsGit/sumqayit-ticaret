<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'store_category' => new StoreTypeResource($this->storeType),
            'store_type' => new MarketResource($this->market),
            'description' => $this->description,
            
            'image' => $this->image ? asset($this->image) : null,
            'image_alt' => $this->image_alt,
            'bottom_image' => $this->bottom_image ? asset($this->bottom_image) : null,
            'bottom_image_alt' => $this->bottom_image_alt,
            'contact' => [
                [
                    'value' => $this->number,
                    'image' => $this->number_image ? asset($this->number_image) : null,
                    'id' => 1
                ],
                [
                    'value' => $this->email,
                    'image' => $this->email_image ? asset($this->email_image) : null,
                    'id' => 2
                ],
                [
                    'value' => $this->link,
                    'image' => $this->link_image ? asset($this->link_image) : null,
                    'id' => 3
                ],
                [
                    'value' => $this->working_hours_az,
                    'image' => $this->working_hours_image ? asset($this->working_hours_image) : null,
                    'id' => 4
                ]
            ],
            'status' => (bool) $this->status,
            
        ];
    }
} 
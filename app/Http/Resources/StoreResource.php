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
            'store_type' => new StoreTypeResource($this->storeType),
            'description' => $this->description,
            
            'image' => $this->image ? asset($this->image) : null,
            'image_alt' => $this->image_alt,
            'bottom_image' => $this->bottom_image ? asset($this->bottom_image) : null,
            'bottom_image_alt' => $this->bottom_image_alt,
            'contact' => [
                [
                    'value_number' => $this->number,
                    'image_number' => $this->number_image ? asset($this->number_image) : null,
                    'id' => $this->id
                ],
                [
                    'value_email' => $this->email,
                    'image_email' => $this->email_image ? asset($this->email_image) : null,
                    'id' => $this->id + 1
                ],
                [
                    'value_link' => $this->link,
                    'image_link' => $this->link_image ? asset($this->link_image) : null,
                    'id' => $this->id + 2
                ],
                [
                    'value_working_hours' => $this->working_hours_az,
                    'image_working_hours' => $this->working_hours_image ? asset($this->working_hours_image) : null,
                    'id' => $this->id + 3
                ]
            ],
            'status' => (bool) $this->status,
            
        ];
    }
} 
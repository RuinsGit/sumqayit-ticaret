<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactRentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand_name' => $this->brand_name,
            'email' => $this->email,
            'phone_prefix' => $this->phone_prefix,
            'phone_number' => $this->phone_number,
            'warehouse' => $this->warehouse,
            'requested_area' => $this->requested_area,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
} 
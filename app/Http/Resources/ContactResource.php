<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            [
                'value' => $this->number,
                'image' => $this->number_image ? asset($this->number_image) : null,
                'title' => $this->filial_description,
                'id' => $this->id,
            ],
            [
                'value' => $this->mail,
                'image' => $this->mail_image ? asset($this->mail_image) : null,
                'title' => $this->filial_description,
                'id' => $this->id + 1,
            ],
            [
                'value' => $this->address,
                'image' => $this->address_image ? asset($this->address_image) : null,
                'title' => $this->filial_description,
                'id' => $this->id + 2,
            ],
            [
                'value' => $this->work_hours,
                'image' => $this->work_hours_image ? asset($this->work_hours_image) : null,
                'title' => $this->filial_description,
                'id' => $this->id + 3,
            ]
        ];
    }
} 
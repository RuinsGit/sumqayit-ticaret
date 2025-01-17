<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'logo_1_image' => asset($this->logo_1_image),
            'logo_2_image' => asset($this->logo_2_image),
            'logo_alt1' => $this->logo_alt1,
            'logo_alt2' => $this->logo_alt2,
            'logo_title1' => $this->logo_title1,
            'logo_title2' => $this->logo_title2,
            
           
        ];
    }
} 
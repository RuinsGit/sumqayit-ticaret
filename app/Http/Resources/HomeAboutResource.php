<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeAboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];
        if ($this->images) {
            $imageArray = is_string($this->images) ? json_decode($this->images, true) : $this->images;
            if (is_array($imageArray)) {
                foreach ($imageArray as $index => $image) {
                    $imagesAlt = is_string($this->{'images_alt_' . app()->getLocale()}) 
                        ? json_decode($this->{'images_alt_' . app()->getLocale()}, true) 
                        : $this->{'images_alt_' . app()->getLocale()};
                    
                    $images[] = [
                        'id' => $index + 1,
                        'image' => asset('./' . $image),
                        'alt' => $imagesAlt[$index] ?? null
                    ];
                }
            }
        }
        
        return [
            'id' => $this->id,
            'title1' => $this->{'title1_' . app()->getLocale()},
            'title2' => $this->{'title2_' . app()->getLocale()},
            'special_title1' => $this->{'special_title1_' . app()->getLocale()},
            'special_title2' => $this->{'special_title2_' . app()->getLocale()},
            'special_title3' => $this->{'special_title3_' . app()->getLocale()},
            'description' => $this->{'description_' . app()->getLocale()},
            'images' => $images,
            
            
            
        ];
    }
} 
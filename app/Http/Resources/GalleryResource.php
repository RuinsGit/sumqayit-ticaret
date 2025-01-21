<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];
        if ($this->multiple_images) {
            $multipleImages = is_string($this->multiple_images) 
                ? json_decode($this->multiple_images, true) 
                : $this->multiple_images;
            
            foreach ($multipleImages as $index => $image) {
                $images[] = [
                    'id' => $index + 1,
                    'image' => asset('storage/' . $image['image']),
                    'alt' => $image['alt_' . app()->getLocale()] ?? null
                ];
            }
        }

        return [
            'id' => $this->id,
            'title' => $this->{'title_' . app()->getLocale()},
            'slug' => [
                'az' => $this->slug_az,
                'en' => $this->slug_en,
                'ru' => $this->slug_ru
            ],
            'description' => $this->{'description_' . app()->getLocale()},
            'main_image' => $this->main_image ? asset('storage/' . $this->main_image) : null,
            'main_image_alt' => $this->{'main_image_alt_' . app()->getLocale()},
            'bottom_image' => $this->bottom_image ? asset('storage/' . $this->bottom_image) : null,
            'bottom_image_alt' => $this->{'bottom_image_alt_' . app()->getLocale()},
            'images' => $images,
            
            'meta_title' => $this->{'meta_title_' . app()->getLocale()},
            'meta_description' => $this->{'meta_description_' . app()->getLocale()},
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

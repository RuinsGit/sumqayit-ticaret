<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $videos = [];
        if ($this->multiple_videos) {
            $multipleVideos = is_string($this->multiple_videos) 
                ? json_decode($this->multiple_videos, true) 
                : $this->multiple_videos;
            
            foreach ($multipleVideos as $index => $video) {
                $videos[] = [
                    'id' => $index + 1,
                    'video' => asset('storage/' . $video['video']),
                    'thumbnail' => $video['thumbnail'] ? asset('storage/' . $video['thumbnail']) : null,
                    'video_alt' => $video['alt_' . app()->getLocale()] ?? null
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
            'main_video' => $this->main_video ? asset('storage/' . $this->main_video) : null,
            'main_video_thumbnail' => $this->main_video_thumbnail ? asset('storage/' . $this->main_video_thumbnail) : null,
            'main_video_alt' => $this->{'main_video_alt_' . app()->getLocale()},
            'bottom_video' => $this->bottom_video ? asset('storage/' . $this->bottom_video) : null,
            'bottom_video_thumbnail' => $this->bottom_video_thumbnail ? asset('storage/' . $this->bottom_video_thumbnail) : null,
            'bottom_video_alt' => $this->{'bottom_video_alt_' . app()->getLocale()},
            'videos' => $videos,
            'meta_title' => $this->{'meta_title_' . app()->getLocale()},
            'meta_description' => $this->{'meta_description_' . app()->getLocale()},
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

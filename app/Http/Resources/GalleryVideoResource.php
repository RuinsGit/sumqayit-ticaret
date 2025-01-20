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
        $multipleVideos = [];
        if ($this->multiple_videos) {
            $videos = is_string($this->multiple_videos) 
                ? json_decode($this->multiple_videos, true) 
                : $this->multiple_videos;
            
            foreach ($videos as $index => $video) {
                $multipleVideos[] = [
                    'id' => $index + 1,
                    'video' => asset('storage/' . $video['video']),
                    'thumbnail' => $video['thumbnail'] ? asset('storage/' . $video['thumbnail']) : null,
                    'alt' => [
                        'az' => $video['alt_az'] ?? null,
                        'en' => $video['alt_en'] ?? null,
                        'ru' => $video['alt_ru'] ?? null
                    ]
                ];
            }
        }

        return [
            'id' => $this->id,
            'title' => [
                'az' => $this->title_az,
                'en' => $this->title_en,
                'ru' => $this->title_ru
            ],
            'slug' => [
                'az' => $this->slug_az,
                'en' => $this->slug_en,
                'ru' => $this->slug_ru
            ],
            'main_video' => $this->main_video ? asset('storage/' . $this->main_video) : null,
            'main_video_thumbnail' => $this->main_video_thumbnail ? asset('storage/' . $this->main_video_thumbnail) : null,
            'main_video_alt' => [
                'az' => $this->main_video_alt_az,
                'en' => $this->main_video_alt_en,
                'ru' => $this->main_video_alt_ru
            ],
            'bottom_video' => $this->bottom_video ? asset('storage/' . $this->bottom_video) : null,
            'bottom_video_thumbnail' => $this->bottom_video_thumbnail ? asset('storage/' . $this->bottom_video_thumbnail) : null,
            'bottom_video_alt' => [
                'az' => $this->bottom_video_alt_az,
                'en' => $this->bottom_video_alt_en,
                'ru' => $this->bottom_video_alt_ru
            ],
            'multiple_videos' => $multipleVideos,
            'meta' => [
                'title' => [
                    'az' => $this->meta_title_az,
                    'en' => $this->meta_title_en,
                    'ru' => $this->meta_title_ru
                ],
                'description' => [
                    'az' => $this->meta_description_az,
                    'en' => $this->meta_description_en,
                    'ru' => $this->meta_description_ru
                ]
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

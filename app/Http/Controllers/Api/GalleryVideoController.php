<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryVideoResource;
use App\Models\GalleryVideo;
use Illuminate\Http\Request;

class GalleryVideoController extends Controller
{
    /**
     * Tüm video galerilerini listele
     */
    public function index()
    {
        try {
            $galleryVideos = GalleryVideo::latest()->get();
            
            return response()->json([
                'success' => true,
                'data' => GalleryVideoResource::collection($galleryVideos)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xəta baş verdi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Belirli bir video galeriyi göster
     */
    public function show($id)
    {
        try {
            $galleryVideo = GalleryVideo::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => new GalleryVideoResource($galleryVideo)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xəta baş verdi: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Slug'a göre video galeriyi göster
     */
    public function getBySlug($lang, $slug)
    {
        try {
            $galleryVideo = GalleryVideo::where('slug_' . $lang, $slug)->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => new GalleryVideoResource($galleryVideo)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xəta baş verdi: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Son eklenen video galerileri getir
     */
    public function getLatest($limit = 6)
    {
        try {
            $galleryVideos = GalleryVideo::latest()
                ->take($limit)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => GalleryVideoResource::collection($galleryVideos)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xəta baş verdi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sayfalı video galerileri getir
     */
    public function getPaginated($perPage = 10)
    {
        try {
            $galleryVideos = GalleryVideo::latest()
                ->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => GalleryVideoResource::collection($galleryVideos)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xəta baş verdi: ' . $e->getMessage()
            ], 500);
        }
    }
}

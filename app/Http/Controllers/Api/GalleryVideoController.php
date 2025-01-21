<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryVideoResource;
use App\Models\GalleryVideo;
use Illuminate\Http\Request;

class GalleryVideoController extends Controller
{
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

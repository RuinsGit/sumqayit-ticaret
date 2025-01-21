<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Resources\GalleryResource;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return GalleryResource::collection($galleries);
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        return new GalleryResource($gallery);
    }

    public function getBySlug($lang, $slug)
    {
        $gallery = Gallery::where("slug_{$lang}", $slug)->firstOrFail();
        return new GalleryResource($gallery);
    }

    public function getLatest($limit = 6)
    {
        $galleries = Gallery::latest()->take($limit)->get();
        return GalleryResource::collection($galleries);
    }

    public function getPaginated($perPage = 10)
    {
        $galleries = Gallery::latest()->paginate($perPage);
        return GalleryResource::collection($galleries);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')
            ->get();
        
        return BlogResource::collection($blogs);
    }

    public function getLatest($limit = 6)
    {
        $blogs = Blog::orderBy('id', 'desc')
            ->take($limit)
            ->get();
        
        return BlogResource::collection($blogs);
    }

    public function getPaginated($perPage = 9)
    {
        $blogs = Blog::orderBy('id', 'desc')
            ->paginate($perPage);
        
        return BlogResource::collection($blogs);
    }

    public function getBySlug($lang, $slug)
    {
        try {
            $blog = Blog::where("slug_$lang", $slug)->firstOrFail();
            return new BlogResource($blog);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
    }

    public function show($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            return new BlogResource($blog);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
    }
} 
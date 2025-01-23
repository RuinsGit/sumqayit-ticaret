<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeAboutResource;
use App\Models\HomeAbout;
use Illuminate\Http\Request;

class HomeAboutApiController extends Controller
{
    public function index()
    {
        $homeAbouts = HomeAbout::orderBy('id', 'desc')->get();
        return HomeAboutResource::collection($homeAbouts);
    }

    public function show($id)
    {
        try {
            $homeAbout = HomeAbout::findOrFail($id);
            return new HomeAboutResource($homeAbout);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Home About not found'], 404);
        }
    }
} 
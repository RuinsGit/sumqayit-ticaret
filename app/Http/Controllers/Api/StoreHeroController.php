<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreHeroResource;
use App\Models\StoreHero;
use Illuminate\Http\Request;

class StoreHeroController extends Controller
{
    public function index()
    {
        $storeHero = StoreHero::all();
        return StoreHeroResource::collection($storeHero);
    }

    public function show($id)
    {
        try {
            $storeHero = StoreHero::findOrFail($id);
            return new StoreHeroResource($storeHero);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Store Hero not found'], 404);
        }
    }

    // Diğer yöntemleri (create, store, edit, update, destroy) API yapısına uygun hale getirin
    // ... mevcut kodu API yapısına uygun hale getirin ...
} 
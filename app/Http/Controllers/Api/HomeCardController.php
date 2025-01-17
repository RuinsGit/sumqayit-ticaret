<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeCardResource;
use App\Models\HomeCard;
use Illuminate\Http\Request;

class HomeCardController extends Controller
{
    public function index()
    {
        $homeCards = HomeCard::all();
        return HomeCardResource::collection($homeCards);
    }

    public function show($id)
    {
        try {
            $homeCard = HomeCard::findOrFail($id);
            return new HomeCardResource($homeCard);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Home Card not found'], 404);
        }
    }

    // Diğer yöntemleri (create, store, edit, update, destroy) API yapısına uygun hale getirin
    // ... mevcut kodu API yapısına uygun hale getirin ...
} 
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreTypeResource;
use App\Models\StoreType;
use Illuminate\Http\Request;

class StoreTypeApiController extends Controller
{
    public function index()
    {
        $storeTypes = StoreType::all();
        if ($storeTypes->isEmpty()) {
            return response()->json(['message' => 'No Store Types found'], 404);
        }
        return StoreTypeResource::collection($storeTypes);
    }

    public function show($id)
    {
        $storeType = StoreType::find($id);
        if (!$storeType) {
            return response()->json(['message' => 'Store Type not found'], 404);
        }
        return new StoreTypeResource($storeType);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_az' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'status' => 'required|boolean'
        ]);

        $storeType = StoreType::create($data);

        return response()->json([
            'message' => 'Mağaza növü uğurla yaradıldı', 
            'data' => new StoreTypeResource($storeType)
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $storeType = StoreType::findOrFail($id);

        $data = $request->validate([
            'name_az' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'status' => 'required|boolean'
        ]);

        $storeType->update($data);

        return response()->json([
            'message' => 'Mağaza növü uğurla yeniləndi', 
            'data' => new StoreTypeResource($storeType)
        ], 200);
    }

    public function destroy($id)
    {
        $storeType = StoreType::findOrFail($id);
        $storeType->delete();

        return response()->json(['message' => 'Mağaza növü uğurla silindi'], 200);
    }
} 
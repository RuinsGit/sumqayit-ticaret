<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreApiController extends Controller
{
    public function index()
    {
        $stores = Store::with('storeType')->get();
        if ($stores->isEmpty()) {
            return response()->json(['message' => 'No Stores found'], 404);
        }
        return StoreResource::collection($stores);
    }

    public function show($id)
    {
        $store = Store::with('storeType')->find($id);
        if (!$store) {
            return response()->json(['message' => 'Store not found'], 404);
        }
        return new StoreResource($store);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'store_type_id' => 'required|exists:store_types,id',
            'description_az' => 'required|string',
            'description_en' => 'required|string',
            'description_ru' => 'required|string',
            'working_hours_az' => 'required|string',
            'working_hours_en' => 'required|string',
            'working_hours_ru' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'image_alt' => 'nullable|string',
            'bottom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'bottom_image_alt' => 'nullable|string',
            'number' => 'nullable|string',
            'number_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'email' => 'nullable|email',
            'email_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'link' => 'nullable|string',
            'link_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'working_hours_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'status' => 'required|boolean'
        ]);

        $data = $this->uploadImages($request, $data);

        $store = Store::create($data);

        return response()->json([
            'message' => 'Mağaza uğurla yaradıldı', 
            'data' => new StoreResource($store)
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $data = $request->validate([
            'store_type_id' => 'required|exists:store_types,id',
            'description_az' => 'required|string',
            'description_en' => 'required|string',
            'description_ru' => 'required|string',
            'working_hours_az' => 'required|string',
            'working_hours_en' => 'required|string',
            'working_hours_ru' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'image_alt' => 'nullable|string',
            'bottom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'bottom_image_alt' => 'nullable|string',
            'number' => 'nullable|string',
            'number_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'email' => 'nullable|email',
            'email_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'link' => 'nullable|string',
            'link_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'working_hours_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'status' => 'required|boolean'
        ]);

        // Handle image uploads
        $data = $this->uploadImages($request, $data, $store);

        $store->update($data);

        return response()->json([
            'message' => 'Mağaza uğurla yeniləndi', 
            'data' => new StoreResource($store)
        ], 200);
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        
        // Delete associated images
        $this->deleteImages($store);
        
        $store->delete();

        return response()->json(['message' => 'Mağaza uğurla silindi'], 200);
    }

    private function uploadImages(Request $request, array $data, Store $store = null)
    {
        $imageFields = [
            'image', 'bottom_image', 'number_image', 'email_image', 
            'link_image', 'working_hours_image'
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                if ($store && $store->$field) {
                    $this->deleteFile($store->$field);
                }
                $data[$field] = $this->saveImage($request->file($field));
            }
        }

        return $data;
    }

    private function saveImage($file)
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $webpFileName = time() . '_' . $originalFileName . '.webp';
        $webpPath = public_path('uploads/' . $webpFileName);

        $imageResource = imagecreatefromstring(file_get_contents($file));
        if ($imageResource) {
            imagewebp($imageResource, $webpPath, 80);
            imagedestroy($imageResource);
            return 'uploads/' . $webpFileName;
        }

        return null;
    }

    private function deleteFile($filePath)
    {
        $fullPath = public_path($filePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    private function deleteImages(Store $store)
    {
        $imageFields = [
            'image', 'bottom_image', 'number_image', 'email_image', 
            'link_image', 'working_hours_image'
        ];

        foreach ($imageFields as $field) {
            if ($store->$field) {
                $this->deleteFile($store->$field);
            }
        }
    }
} 
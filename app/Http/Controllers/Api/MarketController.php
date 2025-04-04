<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MarketResource;
use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    
    public function index()
    {
        $markets = Market::all();
        return MarketResource::collection($markets);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_az' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_alt_az' => 'nullable|string|max:255',
            'image_alt_en' => 'nullable|string|max:255',
            'image_alt_ru' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->handleImageUpload($request->file('image'), 'market');
        }

        $market = Market::create($validated);

        return new MarketResource($market);
    }

    public function show(Market $market)
    {
        return new MarketResource($market);
    }

   
    public function update(Request $request, Market $market)
    {
        $validated = $request->validate([
            'name_az' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_alt_az' => 'nullable|string|max:255',
            'image_alt_en' => 'nullable|string|max:255',
            'image_alt_ru' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($market->image && file_exists(public_path($market->image))) {
                unlink(public_path($market->image));
            }
            $validated['image'] = $this->handleImageUpload($request->file('image'), 'market');
        }

        $market->update($validated);

        return new MarketResource($market);
    }

   
    public function destroy(Market $market)
    {
        if ($market->image && file_exists(public_path($market->image))) {
            unlink(public_path($market->image));
        }

        $market->delete();

        return response()->json(['message' => 'Market successfully deleted.'], 200);
    }

   
    protected function handleImageUpload($file, $prefix = '')
    {
        $destinationPath = public_path('uploads/markets');
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        if ($file->getClientOriginalExtension() === 'svg') {
            $fileName = time() . '_' . $prefix . '_' . $originalFileName . '.svg';
            $file->move($destinationPath, $fileName);
            return 'uploads/markets/' . $fileName;
        } else {
            $webpFileName = time() . '_' . $prefix . '_' . $originalFileName . '.webp';

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                return 'uploads/markets/' . $webpFileName;
            }

            throw new \Exception('Error processing image.');
        }
    }
} 
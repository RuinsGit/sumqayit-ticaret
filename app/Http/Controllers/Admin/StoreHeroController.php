<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;


class StoreHeroController extends Controller
{
    public function index()
    {
        Artisan::call('migrate');
        $storeHero = StoreHero::all();
        $storeHeroExists = StoreHero::count() >= 1;
        return view('back.admin.store-hero.index', compact('storeHero', 'storeHeroExists'));
    }

    public function create()
    {
        return view('back.admin.store-hero.create');
    }

    public function store(Request $request)
    {
        // Check if a StoreHero already exists
        if (StoreHero::count() >= 1) {
            return redirect()->route('back.pages.store-hero.index')
                ->with('error', 'Hal hazırda mağazalar hero mövcuddur!');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_alt_az' => 'required|string',
            'image_alt_en' => 'required|string',
            'image_alt_ru' => 'required|string',
            'title_az' => 'required|string',
            'title_en' => 'required|string',
            'title_ru' => 'required|string',
            'description_az' => 'required|string',
            'description_en' => 'required|string',
            'description_ru' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $destinationPath = public_path('uploads/store-hero');
            
            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);

                $imagePath = 'uploads/store-hero/' . $webpFileName;
                
                StoreHero::create([
                    'image' => $imagePath,
                    'image_alt_az' => $request->image_alt_az,
                    'image_alt_en' => $request->image_alt_en,
                    'image_alt_ru' => $request->image_alt_ru,
                    'title_az' => $request->title_az,
                    'title_en' => $request->title_en,
                    'title_ru' => $request->title_ru,
                    'description_az' => $request->description_az,
                    'description_en' => $request->description_en,
                    'description_ru' => $request->description_ru,
                ]);
            }
        }

        return redirect()->route('back.pages.store-hero.index')
            ->with('success', 'Store Hero uğurla əlavə edildi.');
    }

    public function edit(StoreHero $storeHero)
    {
        return view('back.admin.store-hero.edit', compact('storeHero'));
    }

    public function update(Request $request, StoreHero $storeHero)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_alt_az' => 'required|string',
            'image_alt_en' => 'required|string',
            'image_alt_ru' => 'required|string',
            'title_az' => 'required|string',
            'title_en' => 'required|string',
            'title_ru' => 'required|string',
            'description_az' => 'required|string',
            'description_en' => 'required|string',
            'description_ru' => 'required|string',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($storeHero->image) {
                $oldImagePath = public_path($storeHero->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload and convert new image
            $file = $request->file('image');
            $destinationPath = public_path('uploads/store-hero');
            
            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);

                $data['image'] = 'uploads/store-hero/' . $webpFileName;
            }
        }

        $storeHero->update($data);

        return redirect()->route('back.pages.store-hero.index')
            ->with('success', 'Store Hero uğurla yeniləndi.');
    }

    public function destroy(StoreHero $storeHero)
    {
        if ($storeHero->image) {
            $imagePath = public_path($storeHero->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $storeHero->delete();

        return redirect()->route('back.pages.store-hero.index')
            ->with('success', 'Store Hero uğurla silindi.');
    }
}
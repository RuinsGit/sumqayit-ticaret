<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeCardController extends Controller
{
    public function index()
    {
        $homeCards = HomeCard::all();
        return view('back.admin.home-cards.index', compact('homeCards'));
    }

    public function create()
    {
        return view('back.admin.home-cards.create');
    }

    public function store(Request $request)
    {
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
            $destinationPath = public_path('uploads/homecard');
            
            
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

                $imagePath = 'uploads/homecard/' . $webpFileName;
                
                HomeCard::create([
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

        return redirect()->route('back.pages.home-cards.index')
            ->with('success', 'Home Card uğurla əlavə edildi.');
    }

    public function edit(HomeCard $homeCard)
    {
        return view('back.admin.home-cards.edit', compact('homeCard'));
    }

    public function update(Request $request, HomeCard $homeCard)
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
            
            if ($homeCard->image) {
                $oldImagePath = public_path($homeCard->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            
            $file = $request->file('image');
            $destinationPath = public_path('uploads/homecard');
            
            
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

                $data['image'] = 'uploads/homecard/' . $webpFileName;
            }
        }

        $homeCard->update($data);

        return redirect()->route('back.pages.home-cards.index')
            ->with('success', 'Home Card uğurla yeniləndi.');
    }

    public function destroy(HomeCard $homeCard)
    {
        if ($homeCard->image) {
            $imagePath = public_path($homeCard->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $homeCard->delete();

        return redirect()->route('back.pages.home-cards.index')
            ->with('success', 'Home Card uğurla silindi.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeAbout;
use Illuminate\Http\Request;

class HomeAboutController extends Controller
{
    private $destinationPath;

    public function __construct()
    {
        $this->destinationPath = public_path('uploads/homeabout');
    }

    public function index()
    {
        $homeAbouts = HomeAbout::all();
        return view('back.pages.home-about.index', compact('homeAbouts'));
    }

    public function create()
    {
        return view('back.pages.home-about.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title1_az' => 'required|string|max:255',
            'title1_en' => 'required|string|max:255',
            'title1_ru' => 'required|string|max:255',
            'title2_az' => 'nullable|string|max:255',
            'title2_en' => 'nullable|string|max:255',
            'title2_ru' => 'nullable|string|max:255',
            'special_title1_az' => 'nullable|string|max:255',
            'special_title1_en' => 'nullable|string|max:255',
            'special_title1_ru' => 'nullable|string|max:255',
            'special_title2_az' => 'nullable|string|max:255',
            'special_title2_en' => 'nullable|string|max:255',
            'special_title2_ru' => 'nullable|string|max:255',
            'special_title3_az' => 'nullable|string|max:255',
            'special_title3_en' => 'nullable|string|max:255',
            'special_title3_ru' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif',
            'images_alt_az.*' => 'nullable|string|max:255',
            'images_alt_en.*' => 'nullable|string|max:255',
            'images_alt_ru.*' => 'nullable|string|max:255',
        ]);

        // Dizin kontrolü ve oluşturma
        if (!file_exists($this->destinationPath)) {
            mkdir($this->destinationPath, 0755, true);
        }

        // Resimlerin işlenmesi
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $webpFileName = time() . '_' . $originalFileName . '.webp';

                $imageResource = imagecreatefromstring(file_get_contents($file));
                $webpPath = $this->destinationPath . '/' . $webpFileName;

                if ($imageResource) {
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);
                    $images[] = 'uploads/homeabout/' . $webpFileName;
                }
            }
        }

        $data['images'] = json_encode($images);
        $data['images_alt_az'] = json_encode($request->images_alt_az ?? []);
        $data['images_alt_en'] = json_encode($request->images_alt_en ?? []);
        $data['images_alt_ru'] = json_encode($request->images_alt_ru ?? []);

        HomeAbout::create($data);

        return redirect()->route('back.pages.home-about.index')->with('success', 'Home About uğurla əlavə edildi.');
    }

    public function edit($id)
    {
        $homeAbout = HomeAbout::findOrFail($id);
        return view('back.pages.home-about.edit', compact('homeAbout'));
    }

    public function update(Request $request, $id)
    {
        $homeAbout = HomeAbout::findOrFail($id);

        $data = $request->validate([
            'title1_az' => 'required|string|max:255',
            'title1_en' => 'required|string|max:255',
            'title1_ru' => 'required|string|max:255',
            'title2_az' => 'nullable|string|max:255',
            'title2_en' => 'nullable|string|max:255',
            'title2_ru' => 'nullable|string|max:255',
            'special_title1_az' => 'nullable|string|max:255',
            'special_title1_en' => 'nullable|string|max:255',
            'special_title1_ru' => 'nullable|string|max:255',
            'special_title2_az' => 'nullable|string|max:255',
            'special_title2_en' => 'nullable|string|max:255',
            'special_title2_ru' => 'nullable|string|max:255',
            'special_title3_az' => 'nullable|string|max:255',
            'special_title3_en' => 'nullable|string|max:255',
            'special_title3_ru' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif',
            'images_alt_az.*' => 'nullable|string|max:255',
            'images_alt_en.*' => 'nullable|string|max:255',
            'images_alt_ru.*' => 'nullable|string|max:255',
        ]);

        // Yeni resimler yüklendiyse
        if ($request->hasFile('images')) {
            $images = [];
            
            // Eski resimleri sil
            if ($homeAbout->images) {
                $oldImages = json_decode($homeAbout->images);
                foreach ($oldImages as $oldImage) {
                    $oldImagePath = public_path($oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }

            // Yeni resimleri kaydet
            foreach ($request->file('images') as $key => $file) {
                if ($file->isValid()) {
                    $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $webpFileName = time() . '_' . $originalFileName . '.webp';
                    $webpPath = $this->destinationPath . '/' . $webpFileName;

                    $imageResource = imagecreatefromstring(file_get_contents($file));
                    if ($imageResource) {
                        imagewebp($imageResource, $webpPath, 80);
                        imagedestroy($imageResource);
                        $images[] = 'uploads/homeabout/' . $webpFileName;
                    }
                }
            }
            
            $data['images'] = json_encode($images);
        }

        // Alt textleri güncelle
        $data['images_alt_az'] = json_encode(array_values($request->images_alt_az ?? []));
        $data['images_alt_en'] = json_encode(array_values($request->images_alt_en ?? []));
        $data['images_alt_ru'] = json_encode(array_values($request->images_alt_ru ?? []));

        $homeAbout->update($data);

        return redirect()->route('back.pages.home-about.index')->with('success', 'Home About uğurla yeniləndi.');
    }

    public function destroy($id)
    {
        $homeAbout = HomeAbout::findOrFail($id);

        // Resimleri sil
        if ($homeAbout->images) {
            $images = json_decode($homeAbout->images);
            foreach ($images as $image) {
                $imagePath = public_path($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        $homeAbout->delete();

        return redirect()->route('back.pages.home-about.index')->with('success', 'Home About uğurla silindi.');
    }
}

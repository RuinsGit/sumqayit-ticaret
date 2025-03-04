<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
class HomeAboutController extends Controller
{
    private $destinationPath;

    public function __construct()
    {
        Artisan::call('migrate');
        $this->destinationPath = public_path('uploads/homeabout');
    }

    public function index()
    {
        $homeAbouts = HomeAbout::all();
        
            
        if ($homeAbouts->count() >= 1) {
            return view('back.pages.home-about.index', compact('homeAbouts'))
                ->with('info', 'Hal-hazırda 1 Home About mövcuddur.');
        }
        
        return view('back.pages.home-about.index', compact('homeAbouts'));
    }

    public function create()
    {
        return view('back.pages.home-about.create');
    }

    public function store(Request $request)
    {
            
        if (HomeAbout::count() >= 1) {
            return redirect()->route('back.pages.home-about.index')
                ->with('error', 'Hal-hazırda 1 Home About mövcuddur.');
        }

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
            'description_az' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif',
            'images_alt_az.*' => 'nullable|string|max:255',
            'images_alt_en.*' => 'nullable|string|max:255',
            'images_alt_ru.*' => 'nullable|string|max:255',
        ]);

       
        if (!file_exists($this->destinationPath)) {
            mkdir($this->destinationPath, 0755, true);
        }

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
            'description_az' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif',
            'replacement_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif',
            'images_alt_az.*' => 'nullable|string|max:255',
            'images_alt_en.*' => 'nullable|string|max:255',
            'images_alt_ru.*' => 'nullable|string|max:255',
            'new_images_alt_az.*' => 'nullable|string|max:255',
            'new_images_alt_en.*' => 'nullable|string|max:255',
            'new_images_alt_ru.*' => 'nullable|string|max:255',
            'existing_images.*' => 'nullable|string',
            'delete_images.*' => 'nullable|integer',
        ]);

        
        $existingImages = $request->existing_images ?? [];
        $deleteImages = $request->delete_images ?? [];
        $replacementImages = $request->file('replacement_images') ?? [];
        
        $images = [];
        $imagesAltAz = [];
        $imagesAltEn = [];
        $imagesAltRu = [];
        
      
        if (!empty($existingImages)) {
            foreach ($existingImages as $key => $image) {
                
                if (in_array($key, $deleteImages)) {
                    $oldImagePath = public_path($image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    continue;
                }
                
                
                if (isset($replacementImages[$key]) && $replacementImages[$key]->isValid()) {
                    $file = $replacementImages[$key];
                    $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $webpFileName = time() . '_' . $originalFileName . '.webp';
                    $webpPath = $this->destinationPath . '/' . $webpFileName;
                    
                    $imageResource = imagecreatefromstring(file_get_contents($file));
                    if ($imageResource) {
                        imagewebp($imageResource, $webpPath, 80);
                        imagedestroy($imageResource);
                        
                        // Eski resmi sil
                        $oldImagePath = public_path($image);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                        
                        $images[] = 'uploads/homeabout/' . $webpFileName;
                    }
                } else {
                    
                    $images[] = $image;
                }
                
                
                $imagesAltAz[] = $request->images_alt_az[$key] ?? '';
                $imagesAltEn[] = $request->images_alt_en[$key] ?? '';
                $imagesAltRu[] = $request->images_alt_ru[$key] ?? '';
            }
        }
        
        
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $key => $file) {
                if ($file->isValid()) {
                    $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $webpFileName = time() . '_' . $originalFileName . '_' . $key . '.webp';
                    $webpPath = $this->destinationPath . '/' . $webpFileName;
                    
                    $imageResource = imagecreatefromstring(file_get_contents($file));
                    if ($imageResource) {
                        imagewebp($imageResource, $webpPath, 80);
                        imagedestroy($imageResource);
                        $images[] = 'uploads/homeabout/' . $webpFileName;
                        
                        
                        $imagesAltAz[] = $request->new_images_alt_az[$key] ?? '';
                        $imagesAltEn[] = $request->new_images_alt_en[$key] ?? '';
                        $imagesAltRu[] = $request->new_images_alt_ru[$key] ?? '';
                    }
                }
            }
        }
        
        $data['images'] = json_encode($images);
        $data['images_alt_az'] = json_encode($imagesAltAz);
        $data['images_alt_en'] = json_encode($imagesAltEn);
        $data['images_alt_ru'] = json_encode($imagesAltRu);

        $homeAbout->update($data);

        return redirect()->route('back.pages.home-about.index')->with('success', 'Home About uğurla yeniləndi.');
    }

    public function destroy($id)
    {
        $homeAbout = HomeAbout::findOrFail($id);

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

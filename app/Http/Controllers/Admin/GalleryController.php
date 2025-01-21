<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('back.pages.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('back.pages.galleries.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title_az' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'title_ru' => 'required|string|max:255',
                'description_az' => 'required|string',
                'description_en' => 'required|string',
                'description_ru' => 'required|string',
                'main_image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'main_image_alt_az' => 'required|string|max:255',
                'main_image_alt_en' => 'required|string|max:255',
                'main_image_alt_ru' => 'required|string|max:255',
                'bottom_image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'bottom_image_alt_az' => 'required|string|max:255',
                'bottom_image_alt_en' => 'required|string|max:255',
                'bottom_image_alt_ru' => 'required|string|max:255',
                'bottom_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'bottom_images_alt_az.*' => 'nullable|string|max:255',
                'bottom_images_alt_en.*' => 'nullable|string|max:255',
                'bottom_images_alt_ru.*' => 'nullable|string|max:255',
                'meta_title_az' => 'nullable|string|max:255',
                'meta_title_en' => 'nullable|string|max:255',
                'meta_title_ru' => 'nullable|string|max:255',
                'meta_description_az' => 'nullable|string',
                'meta_description_en' => 'nullable|string',
                'meta_description_ru' => 'nullable|string',
            ]);

            // Ana görsel yükleme
            if ($request->hasFile('main_image')) {
                $file = $request->file('main_image');
                $destinationPath = public_path('storage/gallery/main');
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $webpFileName = time() . '_' . $originalFileName . '.webp';

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $imageResource = imagecreatefromstring(file_get_contents($file));
                $webpPath = $destinationPath . '/' . $webpFileName;

                if ($imageResource) {
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);
                    $mainImagePath = 'gallery/main/' . $webpFileName;
                }
            }

            // Alt görsel yükleme
            if ($request->hasFile('bottom_image')) {
                $file = $request->file('bottom_image');
                $destinationPath = public_path('storage/gallery/bottom');
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $webpFileName = time() . '_' . $originalFileName . '.webp';

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $imageResource = imagecreatefromstring(file_get_contents($file));
                $webpPath = $destinationPath . '/' . $webpFileName;

                if ($imageResource) {
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);
                    $bottomImagePath = 'gallery/bottom/' . $webpFileName;
                }
            }
            
            // Çoklu görseller için dizi oluştur
            $multipleImages = [];
            if ($request->hasFile('bottom_images')) {
                foreach ($request->file('bottom_images') as $key => $file) {
                    $destinationPath = public_path('storage/gallery/multiple');
                    $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $webpFileName = time() . '_' . $key . '_' . $originalFileName . '.webp';

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    $imageResource = imagecreatefromstring(file_get_contents($file));
                    $webpPath = $destinationPath . '/' . $webpFileName;

                    if ($imageResource) {
                        imagewebp($imageResource, $webpPath, 80);
                        imagedestroy($imageResource);
                        
                        $multipleImages[] = [
                            'image' => 'gallery/multiple/' . $webpFileName,
                            'alt_az' => $request->bottom_images_alt_az[$key] ?? '',
                            'alt_en' => $request->bottom_images_alt_en[$key] ?? '',
                            'alt_ru' => $request->bottom_images_alt_ru[$key] ?? ''
                        ];
                    }
                }
            }

            // Galeri oluştur
            Gallery::create([
                'title_az' => $request->title_az,
                'title_en' => $request->title_en,
                'title_ru' => $request->title_ru,
                'description_az' => $request->description_az,
                'description_en' => $request->description_en,
                'description_ru' => $request->description_ru,
                'main_image' => $mainImagePath,
                'main_image_alt_az' => $request->main_image_alt_az,
                'main_image_alt_en' => $request->main_image_alt_en,
                'main_image_alt_ru' => $request->main_image_alt_ru,
                'bottom_image' => $bottomImagePath,
                'bottom_image_alt_az' => $request->bottom_image_alt_az,
                'bottom_image_alt_en' => $request->bottom_image_alt_en,
                'bottom_image_alt_ru' => $request->bottom_image_alt_ru,
                'multiple_images' => $multipleImages,
                'meta_title_az' => $request->meta_title_az,
                'meta_title_en' => $request->meta_title_en,
                'meta_title_ru' => $request->meta_title_ru,
                'meta_description_az' => $request->meta_description_az,
                'meta_description_en' => $request->meta_description_en,
                'meta_description_ru' => $request->meta_description_ru,
            ]);

            return redirect()
                ->route('back.pages.galleries.index')
                ->with('success', 'Qalereya uğurla əlavə edildi');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function edit(Gallery $gallery)
    {
        return view('back.pages.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        try {
            $request->validate([
                'title_az' => 'required',
                'title_en' => 'required',
                'title_ru' => 'required',
                'description_az' => 'required',
                'description_en' => 'required',
                'description_ru' => 'required',
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'main_image_alt_az' => 'required',
                'main_image_alt_en' => 'required',
                'main_image_alt_ru' => 'required',
                'bottom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'bottom_image_alt_az' => 'required',
                'bottom_image_alt_en' => 'required',
                'bottom_image_alt_ru' => 'required',
                'bottom_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ]);

            $data = $request->except(['main_image', 'bottom_image', 'bottom_images', 'existing_images', 'existing_images_alt_az', 'existing_images_alt_en', 'existing_images_alt_ru']);

            if ($request->hasFile('main_image')) {
                if ($gallery->main_image) {
                    Storage::disk('public')->delete($gallery->main_image);
                }

                $file = $request->file('main_image');
                $destinationPath = public_path('storage/gallery/main');
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $webpFileName = time() . '_' . $originalFileName . '.webp';

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $imageResource = imagecreatefromstring(file_get_contents($file));
                $webpPath = $destinationPath . '/' . $webpFileName;

                if ($imageResource) {
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);
                    $data['main_image'] = 'gallery/main/' . $webpFileName;
                }
            }

           
            if ($request->hasFile('bottom_image')) {
                
                if ($gallery->bottom_image) {
                    Storage::disk('public')->delete($gallery->bottom_image);
                }

                $file = $request->file('bottom_image');
                $destinationPath = public_path('storage/gallery/bottom');
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $webpFileName = time() . '_' . $originalFileName . '.webp';

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $imageResource = imagecreatefromstring(file_get_contents($file));
                $webpPath = $destinationPath . '/' . $webpFileName;

                if ($imageResource) {
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);
                    $data['bottom_image'] = 'gallery/bottom/' . $webpFileName;
                }
            }

            
            $multipleImages = [];
            
            
            if ($request->has('existing_images')) {
                $existingImages = $request->existing_images;
                $existingImagesAltAz = $request->existing_images_alt_az;
                $existingImagesAltEn = $request->existing_images_alt_en;
                $existingImagesAltRu = $request->existing_images_alt_ru;

                foreach ($existingImages as $key => $image) {
                    $multipleImages[] = [
                        'image' => $image,
                        'alt_az' => $existingImagesAltAz[$key] ?? '',
                        'alt_en' => $existingImagesAltEn[$key] ?? '',
                        'alt_ru' => $existingImagesAltRu[$key] ?? ''
                    ];
                }
            }

            
            if ($gallery->multiple_images) {
                $oldImages = collect($gallery->multiple_images)->pluck('image')->toArray();
                $keepImages = $request->has('existing_images') ? $request->existing_images : [];
                
                
                $deletedImages = array_diff($oldImages, $keepImages);
                foreach ($deletedImages as $deletedImage) {
                    Storage::disk('public')->delete($deletedImage);
                }
            }

          
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $key => $file) {
                    $destinationPath = public_path('storage/gallery/multiple');
                    $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $webpFileName = time() . '_' . $key . '_' . $originalFileName . '.webp';

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    $imageResource = imagecreatefromstring(file_get_contents($file));
                    $webpPath = $destinationPath . '/' . $webpFileName;

                    if ($imageResource) {
                        imagewebp($imageResource, $webpPath, 80);
                        imagedestroy($imageResource);
                        
                        $multipleImages[] = [
                            'image' => 'gallery/multiple/' . $webpFileName,
                            'alt_az' => $request->input('new_images_alt_az.' . $key, ''),
                            'alt_en' => $request->input('new_images_alt_en.' . $key, ''),
                            'alt_ru' => $request->input('new_images_alt_ru.' . $key, '')
                        ];
                    }
                }
            }

            $data['multiple_images'] = $multipleImages;
            $gallery->update($data);

            return redirect()
                ->route('back.pages.galleries.index')
                ->with('success', 'Qalereya uğurla yeniləndi');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function destroy(Gallery $gallery)
    {
        try {
            
            if ($gallery->main_image) {
                Storage::disk('public')->delete($gallery->main_image);
            }
            if ($gallery->bottom_image) {
                Storage::disk('public')->delete($gallery->bottom_image);
            }
            if (!empty($gallery->multiple_images)) {
                foreach ($gallery->multiple_images as $image) {
                    Storage::disk('public')->delete($image['image']);
                }
            }

            $gallery->delete();

            return redirect()
                ->route('back.pages.galleries.index')
                ->with('success', 'Qalereya uğurla silindi');

        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }
} 
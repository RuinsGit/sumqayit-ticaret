<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('back.pages.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('back.pages.blog.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_az' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'title_ru' => 'nullable|string|max:255',
            'slug_az' => 'nullable|string|max:255|unique:blogs,slug_az',
            'slug_en' => 'nullable|string|max:255|unique:blogs,slug_en',
            'slug_ru' => 'nullable|string|max:255|unique:blogs,slug_ru',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif',
            'main_image_alt_az' => 'nullable|string|max:255',
            'main_image_alt_en' => 'nullable|string|max:255',
            'main_image_alt_ru' => 'nullable|string|max:255',
            'bottom_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif',
            'bottom_images_alt_az.*' => 'nullable|string|max:255',
            'bottom_images_alt_en.*' => 'nullable|string|max:255',
            'bottom_images_alt_ru.*' => 'nullable|string|max:255',
            'text_az' => 'nullable|string',
            'text_en' => 'nullable|string',
            'text_ru' => 'nullable|string',
            'description_1_az' => 'nullable|string',
            'description_1_en' => 'nullable|string',
            'description_1_ru' => 'nullable|string',
            'description_2_az' => 'nullable|string',
            'description_2_en' => 'nullable|string',
            'description_2_ru' => 'nullable|string',
            'meta_title_az' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_title_ru' => 'nullable|string|max:255',
            'meta_description_az' => 'nullable|string',
            'meta_description_en' => 'nullable|string',
            'meta_description_ru' => 'nullable|string'
        ]);

       
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $destinationPath = public_path('uploads');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);

                $data['main_image'] = 'uploads/' . $webpFileName;
            }
        }

        if ($request->hasFile('bottom_images')) {
            $bottomImages = [];
            $bottomImagesAltAz = [];
            $bottomImagesAltEn = [];
            $bottomImagesAltRu = [];

            foreach ($request->file('bottom_images') as $key => $file) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $webpFileName = time() . '_' . $originalFileName . '.webp';
                $destinationPath = public_path('uploads');

                $imageResource = imagecreatefromstring(file_get_contents($file));
                $webpPath = $destinationPath . '/' . $webpFileName;

                if ($imageResource) {
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);

                    $bottomImages[] = 'uploads/' . $webpFileName;
                    
                    $bottomImagesAltAz[] = $request->bottom_images_alt_az[$key] ?? '';
                    $bottomImagesAltEn[] = $request->bottom_images_alt_en[$key] ?? '';
                    $bottomImagesAltRu[] = $request->bottom_images_alt_ru[$key] ?? '';
                }
            }
            
            $data['bottom_images'] = json_encode($bottomImages);
            $data['bottom_images_alt_az'] = json_encode($bottomImagesAltAz);
            $data['bottom_images_alt_en'] = json_encode($bottomImagesAltEn);
            $data['bottom_images_alt_ru'] = json_encode($bottomImagesAltRu);
        }

        Blog::create($data);

        return redirect()->route('back.pages.blog.index')->with('success', 'Bloq uğurla yaradıldı.');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('back.pages.blog.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title_az' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'title_ru' => 'nullable|string|max:255',
            'slug_az' => 'nullable|string|max:255|unique:blogs,slug_az,'.$id,
            'slug_en' => 'nullable|string|max:255|unique:blogs,slug_en,'.$id,
            'slug_ru' => 'nullable|string|max:255|unique:blogs,slug_ru,'.$id,
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif',
            'main_image_alt_az' => 'nullable|string|max:255',
            'main_image_alt_en' => 'nullable|string|max:255',
            'main_image_alt_ru' => 'nullable|string|max:255',
            'bottom_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif',
            'bottom_images_alt_az.*' => 'nullable|string|max:255',
            'bottom_images_alt_en.*' => 'nullable|string|max:255',
            'bottom_images_alt_ru.*' => 'nullable|string|max:255',
            'text_az' => 'nullable|string',
            'text_en' => 'nullable|string',
            'text_ru' => 'nullable|string',
            'description_1_az' => 'nullable|string',
            'description_1_en' => 'nullable|string',
            'description_1_ru' => 'nullable|string',
            'description_2_az' => 'nullable|string',
            'description_2_en' => 'nullable|string',
            'description_2_ru' => 'nullable|string',
            'meta_title_az' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_title_ru' => 'nullable|string|max:255',
            'meta_description_az' => 'nullable|string',
            'meta_description_en' => 'nullable|string',
            'meta_description_ru' => 'nullable|string'
        ]);

        if ($request->hasFile('main_image')) {
            if ($blog->main_image) {
                $oldImagePath = public_path($blog->main_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('main_image');
            $destinationPath = public_path('uploads');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);

                $data['main_image'] = 'uploads/' . $webpFileName;
            }
        }

        if ($request->hasFile('bottom_images')) {
            if ($blog->bottom_images) {
                $oldImages = json_decode($blog->bottom_images);
                foreach ($oldImages as $oldImage) {
                    $oldImagePath = public_path($oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }

            $bottomImages = [];
            $bottomImagesAltAz = [];
            $bottomImagesAltEn = [];
            $bottomImagesAltRu = [];

            foreach ($request->file('bottom_images') as $key => $file) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $webpFileName = time() . '_' . $originalFileName . '.webp';
                $destinationPath = public_path('uploads');

                $imageResource = imagecreatefromstring(file_get_contents($file));
                $webpPath = $destinationPath . '/' . $webpFileName;

                if ($imageResource) {
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);

                    $bottomImages[] = 'uploads/' . $webpFileName;
                    
                    $bottomImagesAltAz[] = $request->bottom_images_alt_az[$key] ?? '';
                    $bottomImagesAltEn[] = $request->bottom_images_alt_en[$key] ?? '';
                    $bottomImagesAltRu[] = $request->bottom_images_alt_ru[$key] ?? '';
                }
            }
            
            $data['bottom_images'] = json_encode($bottomImages);
            $data['bottom_images_alt_az'] = json_encode($bottomImagesAltAz);
            $data['bottom_images_alt_en'] = json_encode($bottomImagesAltEn);
            $data['bottom_images_alt_ru'] = json_encode($bottomImagesAltRu);
        }

        $blog->update($data);

        return redirect()->route('back.pages.blog.index')->with('success', 'Bloq uğurla yeniləndi.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        
        if ($blog->main_image) {
            $mainImagePath = public_path($blog->main_image);
            if (file_exists($mainImagePath)) {
                unlink($mainImagePath);
            }
        }

        if ($blog->bottom_images) {
            $bottomImages = json_decode($blog->bottom_images);
            foreach ($bottomImages as $image) {
                $imagePath = public_path($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        $blog->delete();

        return redirect()->route('back.pages.blog.index')->with('success', 'Bloq uğurla silindi.');
    }
}

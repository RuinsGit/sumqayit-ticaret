<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryVideoController extends Controller
{
    public function index()
    {
        $galleryVideos = GalleryVideo::latest()->get();
        return view('back.pages.gallery-videos.index', compact('galleryVideos'));
    }

    public function create()
    {
        return view('back.pages.gallery-videos.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title_az' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'title_ru' => 'required|string|max:255',
                'main_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime |max:999999999',
                'main_video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'main_video_alt_az' => 'nullable|string|max:255',
                'main_video_alt_en' => 'nullable|string|max:255',
                'main_video_alt_ru' => 'nullable|string|max:255',
                'bottom_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime |max:999999999',
                'bottom_video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'bottom_video_alt_az' => 'nullable|string|max:255',
                'bottom_video_alt_en' => 'nullable|string|max:255',
                'bottom_video_alt_ru' => 'nullable|string|max:255',
                'videos.*' => 'nullable|file|mimetypes:video/mp4,video/quicktime |max:999999999',
                'videos_thumbnail.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'videos_alt_az.*' => 'nullable|string|max:255',
                'videos_alt_en.*' => 'nullable|string|max:255',
                'videos_alt_ru.*' => 'nullable|string|max:255',
                'meta_title_az' => 'nullable|string|max:255',
                'meta_title_en' => 'nullable|string|max:255',
                'meta_title_ru' => 'nullable|string|max:255',
                'meta_description_az' => 'nullable|string',
                'meta_description_en' => 'nullable|string',
                'meta_description_ru' => 'nullable|string',
            ]);

            // Değişkenleri tanımla (varsayılan olarak null)
            $mainVideoPath = null;
            $mainThumbnailPath = null;
            $bottomVideoPath = null;
            $bottomThumbnailPath = null;

            if ($request->hasFile('main_video')) {
                $mainVideo = $request->file('main_video');
                $mainVideoName = time() . '_' . $mainVideo->getClientOriginalName();
                $mainVideo->move(public_path('uploads/gallery-videos/main'), $mainVideoName);
                $mainVideoPath = 'uploads/gallery-videos/main/' . $mainVideoName;
            }

            if ($request->hasFile('main_video_thumbnail')) {
                $mainThumbnail = $request->file('main_video_thumbnail');
                $originalFileName = pathinfo($mainThumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $mainThumbnailName = time() . '_thumb_' . $originalFileName . '.webp';
                
                $imageResource = imagecreatefromstring(file_get_contents($mainThumbnail));
                $webpPath = public_path('uploads/gallery-videos/thumbnails/' . $mainThumbnailName);
                
                if ($imageResource) {
                    if (!file_exists(public_path('uploads/gallery-videos/thumbnails'))) {
                        mkdir(public_path('uploads/gallery-videos/thumbnails'), 0777, true);
                    }
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);
                    $mainThumbnailPath = 'uploads/gallery-videos/thumbnails/' . $mainThumbnailName;
                }
            }

            if ($request->hasFile('bottom_video')) {
                $bottomVideo = $request->file('bottom_video');
                $bottomVideoName = time() . '_' . $bottomVideo->getClientOriginalName();
                $bottomVideo->move(public_path('uploads/gallery-videos/bottom'), $bottomVideoName);
                $bottomVideoPath = 'uploads/gallery-videos/bottom/' . $bottomVideoName;
            }

            if ($request->hasFile('bottom_video_thumbnail')) {
                $bottomThumbnail = $request->file('bottom_video_thumbnail');
                $originalFileName = pathinfo($bottomThumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $bottomThumbnailName = time() . '_thumb_' . $originalFileName . '.webp';
                
                $imageResource = imagecreatefromstring(file_get_contents($bottomThumbnail));
                $webpPath = public_path('uploads/gallery-videos/thumbnails/' . $bottomThumbnailName);
                
                if ($imageResource) {
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);
                    $bottomThumbnailPath = 'uploads/gallery-videos/thumbnails/' . $bottomThumbnailName;
                }
            }

            $multipleVideos = [];
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $key => $video) {
                    $videoName = time() . '_' . $key . '_' . $video->getClientOriginalName();
                    $video->move(public_path('uploads/gallery-videos/multiple'), $videoName);
                    
                    $thumbnail = $request->file('videos_thumbnail')[$key];
                    $originalFileName = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                    $thumbnailName = time() . '_thumb_' . $key . '_' . $originalFileName . '.webp';
                    
                    $imageResource = imagecreatefromstring(file_get_contents($thumbnail));
                    $webpPath = public_path('uploads/gallery-videos/thumbnails/' . $thumbnailName);
                    
                    if ($imageResource) {
                        imagewebp($imageResource, $webpPath, 80);
                        imagedestroy($imageResource);
                        
                        $multipleVideos[] = [
                            'video' => 'uploads/gallery-videos/multiple/' . $videoName,
                            'thumbnail' => 'uploads/gallery-videos/thumbnails/' . $thumbnailName,
                            'alt_az' => $request->videos_alt_az[$key] ?? '',
                            'alt_en' => $request->videos_alt_en[$key] ?? '',
                            'alt_ru' => $request->videos_alt_ru[$key] ?? ''
                        ];
                    }
                }
            }
                
            $slugAz = str()->slug($request->title_az);
            $slugEn = str()->slug($request->title_en);
            $slugRu = str()->slug($request->title_ru);

            GalleryVideo::create([
                'title_az' => $request->title_az,
                'title_en' => $request->title_en,
                'title_ru' => $request->title_ru,
                'slug_az' => $slugAz,
                'slug_en' => $slugEn,
                'slug_ru' => $slugRu,
                'main_video' => $mainVideoPath,
                'main_video_thumbnail' => $mainThumbnailPath,
                'main_video_alt_az' => $request->main_video_alt_az,
                'main_video_alt_en' => $request->main_video_alt_en,
                'main_video_alt_ru' => $request->main_video_alt_ru,
                'bottom_video' => $bottomVideoPath,
                'bottom_video_thumbnail' => $bottomThumbnailPath,
                'bottom_video_alt_az' => $request->bottom_video_alt_az,
                'bottom_video_alt_en' => $request->bottom_video_alt_en,
                'bottom_video_alt_ru' => $request->bottom_video_alt_ru,
                'multiple_videos' => $multipleVideos,
                'meta_title_az' => $request->meta_title_az,
                'meta_title_en' => $request->meta_title_en,
                'meta_title_ru' => $request->meta_title_ru,
                'meta_description_az' => $request->meta_description_az,
                'meta_description_en' => $request->meta_description_en,
                'meta_description_ru' => $request->meta_description_ru,
            ]);

            return redirect()
                ->route('back.pages.gallery-videos.index')
                ->with('success', 'Video qalereyası uğurla əlavə edildi');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function edit(GalleryVideo $galleryVideo)
    {
        return view('back.pages.gallery-videos.edit', compact('galleryVideo'));
    }

    public function update(Request $request, GalleryVideo $galleryVideo)
    {
        try {
            $request->validate([
                'title_az' => 'required',
                'title_en' => 'required',
                'title_ru' => 'required',
                'main_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime |max:999999999',
                'main_video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'main_video_alt_az' => 'nullable',
                'main_video_alt_en' => 'nullable',
                'main_video_alt_ru' => 'nullable',
                'bottom_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime |max:999999999',
                'bottom_video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'bottom_video_alt_az' => 'nullable',
                'bottom_video_alt_en' => 'nullable',
                'bottom_video_alt_ru' => 'nullable',
            ]);

            // Main video işlemleri
            if ($request->hasFile('main_video')) {
                if ($galleryVideo->main_video && file_exists(public_path($galleryVideo->main_video))) {
                    unlink(public_path($galleryVideo->main_video));
                }
                $mainVideo = $request->file('main_video');
                $mainVideoName = time() . '_' . $mainVideo->getClientOriginalName();
                $mainVideo->move(public_path('uploads/gallery-videos/main'), $mainVideoName);
                $galleryVideo->main_video = 'uploads/gallery-videos/main/' . $mainVideoName;
            }

            // Main video thumbnail işlemleri
            if ($request->hasFile('main_video_thumbnail')) {
                if ($galleryVideo->main_video_thumbnail && file_exists(public_path($galleryVideo->main_video_thumbnail))) {
                    unlink(public_path($galleryVideo->main_video_thumbnail));
                }
                $mainThumbnail = $request->file('main_video_thumbnail');
                $originalFileName = pathinfo($mainThumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $mainThumbnailName = time() . '_thumb_' . $originalFileName . '.webp';
                
                $imageResource = imagecreatefromstring(file_get_contents($mainThumbnail));
                $webpPath = public_path('uploads/gallery-videos/thumbnails/' . $mainThumbnailName);
                
                if ($imageResource) {
                    if (!file_exists(public_path('uploads/gallery-videos/thumbnails'))) {
                        mkdir(public_path('uploads/gallery-videos/thumbnails'), 0777, true);
                    }
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);
                    $galleryVideo->main_video_thumbnail = 'uploads/gallery-videos/thumbnails/' . $mainThumbnailName;
                }
            }

            // Bottom video işlemleri
            if ($request->hasFile('bottom_video')) {
                if ($galleryVideo->bottom_video && file_exists(public_path($galleryVideo->bottom_video))) {
                    unlink(public_path($galleryVideo->bottom_video));
                }
                $bottomVideo = $request->file('bottom_video');
                $bottomVideoName = time() . '_' . $bottomVideo->getClientOriginalName();
                $bottomVideo->move(public_path('uploads/gallery-videos/bottom'), $bottomVideoName);
                $galleryVideo->bottom_video = 'uploads/gallery-videos/bottom/' . $bottomVideoName;
            }

            // Bottom video thumbnail işlemleri
            if ($request->hasFile('bottom_video_thumbnail')) {
                if ($galleryVideo->bottom_video_thumbnail && file_exists(public_path($galleryVideo->bottom_video_thumbnail))) {
                    unlink(public_path($galleryVideo->bottom_video_thumbnail));
                }
                $bottomThumbnail = $request->file('bottom_video_thumbnail');
                $originalFileName = pathinfo($bottomThumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $bottomThumbnailName = time() . '_thumb_' . $originalFileName . '.webp';
                
                $imageResource = imagecreatefromstring(file_get_contents($bottomThumbnail));
                $webpPath = public_path('uploads/gallery-videos/thumbnails/' . $bottomThumbnailName);
                
                if ($imageResource) {
                    if (!file_exists(public_path('uploads/gallery-videos/thumbnails'))) {
                        mkdir(public_path('uploads/gallery-videos/thumbnails'), 0777, true);
                    }
                    imagewebp($imageResource, $webpPath, 80);
                    imagedestroy($imageResource);
                    $galleryVideo->bottom_video_thumbnail = 'uploads/gallery-videos/thumbnails/' . $bottomThumbnailName;
                }
            }

            $multipleVideos = [];

            if ($request->has('existing_videos')) {
                $existingVideoUrls = $request->existing_videos;
                
                foreach ($galleryVideo->multiple_videos as $currentVideo) {
                    if (!in_array($currentVideo['video'], $existingVideoUrls)) {
                        if (file_exists(public_path($currentVideo['video']))) {
                            unlink(public_path($currentVideo['video']));
                        }
                        if (!empty($currentVideo['thumbnail']) && file_exists(public_path($currentVideo['thumbnail']))) {
                            unlink(public_path($currentVideo['thumbnail']));
                        }
                    }
                }

                foreach ($request->existing_videos as $key => $video) {
                    if (!empty($video)) {
                        $oldVideo = collect($galleryVideo->multiple_videos)->firstWhere('video', $video);
                        $thumbnail = $oldVideo['thumbnail'] ?? $request->existing_thumbnails[$key] ?? '';

                        $multipleVideos[] = [
                            'video' => $video,
                            'thumbnail' => $thumbnail,
                            'alt_az' => $request->existing_videos_alt_az[$key] ?? '',
                            'alt_en' => $request->existing_videos_alt_en[$key] ?? '',
                            'alt_ru' => $request->existing_videos_alt_ru[$key] ?? ''
                        ];
                    }
                }
            }

            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $key => $video) {
                    $videoName = time() . '_' . $key . '_' . $video->getClientOriginalName();
                    $video->move(public_path('uploads/gallery-videos/multiple'), $videoName);
                    
                    $thumbnailName = null;
                    if ($request->hasFile('videos_thumbnail') && isset($request->file('videos_thumbnail')[$key])) {
                        $thumbnail = $request->file('videos_thumbnail')[$key];
                        $originalFileName = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                        $thumbnailName = time() . '_thumb_' . $key . '_' . $originalFileName . '.webp';
                        
                        $imageResource = imagecreatefromstring(file_get_contents($thumbnail));
                        $webpPath = public_path('uploads/gallery-videos/thumbnails/' . $thumbnailName);
                        
                        if ($imageResource) {
                            imagewebp($imageResource, $webpPath, 80);
                            imagedestroy($imageResource);
                        }
                    }
                    
                    $multipleVideos[] = [
                        'video' => 'uploads/gallery-videos/multiple/' . $videoName,
                        'thumbnail' => $thumbnailName ? 'uploads/gallery-videos/thumbnails/' . $thumbnailName : '',
                        'alt_az' => $request->input('videos_alt_az.' . $key, ''),
                        'alt_en' => $request->input('videos_alt_en.' . $key, ''),
                        'alt_ru' => $request->input('videos_alt_ru.' . $key, '')
                    ];
                }
            }

            if (!empty($multipleVideos)) {
                $galleryVideo->multiple_videos = $multipleVideos;
            }

            $galleryVideo->title_az = $request->title_az;
            $galleryVideo->title_en = $request->title_en;
            $galleryVideo->title_ru = $request->title_ru;
            $galleryVideo->slug_az = str()->slug($request->title_az);
            $galleryVideo->slug_en = str()->slug($request->title_en);
            $galleryVideo->slug_ru = str()->slug($request->title_ru);
            $galleryVideo->main_video_alt_az = $request->main_video_alt_az;
            $galleryVideo->main_video_alt_en = $request->main_video_alt_en;
            $galleryVideo->main_video_alt_ru = $request->main_video_alt_ru;
            $galleryVideo->bottom_video_alt_az = $request->bottom_video_alt_az;
            $galleryVideo->bottom_video_alt_en = $request->bottom_video_alt_en;
            $galleryVideo->bottom_video_alt_ru = $request->bottom_video_alt_ru;

            if ($request->filled('meta_title_az')) $galleryVideo->meta_title_az = $request->meta_title_az;
            if ($request->filled('meta_title_en')) $galleryVideo->meta_title_en = $request->meta_title_en;
            if ($request->filled('meta_title_ru')) $galleryVideo->meta_title_ru = $request->meta_title_ru;
            if ($request->filled('meta_description_az')) $galleryVideo->meta_description_az = $request->meta_description_az;
            if ($request->filled('meta_description_en')) $galleryVideo->meta_description_en = $request->meta_description_en;
            if ($request->filled('meta_description_ru')) $galleryVideo->meta_description_ru = $request->meta_description_ru;

            if (!$galleryVideo->save()) {
                throw new \Exception('Güncelleme işlemi başarısız oldu.');
            }

            return redirect()->route('back.pages.gallery-videos.index')
                ->with('success', 'Video qalereyası uğurla yeniləndi');

        } catch (\Exception $e) {
            \Log::error('Güncelleme hatası:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function destroy(GalleryVideo $galleryVideo)
    {
        try {
            
            if ($galleryVideo->main_video && file_exists(public_path($galleryVideo->main_video))) {
                unlink(public_path($galleryVideo->main_video));
            }
            if ($galleryVideo->main_video_thumbnail && file_exists(public_path($galleryVideo->main_video_thumbnail))) {
                unlink(public_path($galleryVideo->main_video_thumbnail));
            }
            if ($galleryVideo->bottom_video && file_exists(public_path($galleryVideo->bottom_video))) {
                unlink(public_path($galleryVideo->bottom_video));
            }
            if ($galleryVideo->bottom_video_thumbnail && file_exists(public_path($galleryVideo->bottom_video_thumbnail))) {
                unlink(public_path($galleryVideo->bottom_video_thumbnail));
            }
            if (!empty($galleryVideo->multiple_videos)) {
                foreach ($galleryVideo->multiple_videos as $video) {
                    if (file_exists(public_path($video['video']))) {
                        unlink(public_path($video['video']));
                    }
                    if (!empty($video['thumbnail']) && file_exists(public_path($video['thumbnail']))) {
                        unlink(public_path($video['thumbnail']));
                    }
                }
            }

            $galleryVideo->delete();

            return redirect()
                ->route('back.pages.gallery-videos.index')
                ->with('success', 'Video qalereyası uğurla silindi');

        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }
}

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
                'main_video' => 'required|file|mimetypes:video/mp4,video/quicktime',
                'main_video_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
                'main_video_alt_az' => 'required|string|max:255',
                'main_video_alt_en' => 'required|string|max:255',
                'main_video_alt_ru' => 'required|string|max:255',
                'bottom_video' => 'required|file|mimetypes:video/mp4,video/quicktime',
                'bottom_video_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
                'bottom_video_alt_az' => 'required|string|max:255',
                'bottom_video_alt_en' => 'required|string|max:255',
                'bottom_video_alt_ru' => 'required|string|max:255',
                'videos.*' => 'nullable|file|mimetypes:video/mp4,video/quicktime',
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

            // Ana video yükleme
            if ($request->hasFile('main_video')) {
                $mainVideo = $request->file('main_video');
                $mainVideoName = time() . '_' . $mainVideo->getClientOriginalName();
                $mainVideo->storeAs('public/gallery-videos/main', $mainVideoName);
                $mainVideoPath = 'gallery-videos/main/' . $mainVideoName;
            }

            // Ana video thumbnail yükleme
            if ($request->hasFile('main_video_thumbnail')) {
                $mainThumbnail = $request->file('main_video_thumbnail');
                $mainThumbnailName = time() . '_thumb_' . $mainThumbnail->getClientOriginalName();
                $mainThumbnail->storeAs('public/gallery-videos/thumbnails', $mainThumbnailName);
                $mainThumbnailPath = 'gallery-videos/thumbnails/' . $mainThumbnailName;
            }

            // Alt video yükleme
            if ($request->hasFile('bottom_video')) {
                $bottomVideo = $request->file('bottom_video');
                $bottomVideoName = time() . '_' . $bottomVideo->getClientOriginalName();
                $bottomVideo->storeAs('public/gallery-videos/bottom', $bottomVideoName);
                $bottomVideoPath = 'gallery-videos/bottom/' . $bottomVideoName;
            }

            // Alt video thumbnail yükleme
            if ($request->hasFile('bottom_video_thumbnail')) {
                $bottomThumbnail = $request->file('bottom_video_thumbnail');
                $bottomThumbnailName = time() . '_thumb_' . $bottomThumbnail->getClientOriginalName();
                $bottomThumbnail->storeAs('public/gallery-videos/thumbnails', $bottomThumbnailName);
                $bottomThumbnailPath = 'gallery-videos/thumbnails/' . $bottomThumbnailName;
            }

            // Çoklu videolar için dizi oluştur
            $multipleVideos = [];
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $key => $video) {
                    $videoName = time() . '_' . $key . '_' . $video->getClientOriginalName();
                    $video->storeAs('public/gallery-videos/multiple', $videoName);
                    
                    // Video thumbnail
                    $thumbnail = $request->file('videos_thumbnail')[$key];
                    $thumbnailName = time() . '_thumb_' . $key . '_' . $thumbnail->getClientOriginalName();
                    $thumbnail->storeAs('public/gallery-videos/thumbnails', $thumbnailName);
                    
                    $multipleVideos[] = [
                        'video' => 'gallery-videos/multiple/' . $videoName,
                        'thumbnail' => 'gallery-videos/thumbnails/' . $thumbnailName,
                        'alt_az' => $request->videos_alt_az[$key] ?? '',
                        'alt_en' => $request->videos_alt_en[$key] ?? '',
                        'alt_ru' => $request->videos_alt_ru[$key] ?? ''
                    ];
                }
            }

            // Slugları oluştur
            $slugAz = str()->slug($request->title_az);
            $slugEn = str()->slug($request->title_en);
            $slugRu = str()->slug($request->title_ru);

            // Gallery Video oluştur
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
                'main_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime',
                'main_video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'main_video_alt_az' => 'required',
                'main_video_alt_en' => 'required',
                'main_video_alt_ru' => 'required',
                'bottom_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime',
                'bottom_video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'bottom_video_alt_az' => 'required',
                'bottom_video_alt_en' => 'required',
                'bottom_video_alt_ru' => 'required',
            ]);

            // Önce mevcut videoları al
            $currentVideos = is_string($galleryVideo->multiple_videos) 
                ? json_decode($galleryVideo->multiple_videos, true) 
                : ($galleryVideo->multiple_videos ?? []);

            // Temel alanları güncelle
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

            // Meta alanlarını güncelle
            if ($request->filled('meta_title_az')) $galleryVideo->meta_title_az = $request->meta_title_az;
            if ($request->filled('meta_title_en')) $galleryVideo->meta_title_en = $request->meta_title_en;
            if ($request->filled('meta_title_ru')) $galleryVideo->meta_title_ru = $request->meta_title_ru;
            if ($request->filled('meta_description_az')) $galleryVideo->meta_description_az = $request->meta_description_az;
            if ($request->filled('meta_description_en')) $galleryVideo->meta_description_en = $request->meta_description_en;
            if ($request->filled('meta_description_ru')) $galleryVideo->meta_description_ru = $request->meta_description_ru;

            // Ana video güncelleme
            if ($request->hasFile('main_video')) {
                if ($galleryVideo->main_video) {
                    Storage::disk('public')->delete($galleryVideo->main_video);
                }
                $mainVideo = $request->file('main_video');
                $mainVideoName = time() . '_' . $mainVideo->getClientOriginalName();
                $mainVideo->storeAs('public/gallery-videos/main', $mainVideoName);
                $galleryVideo->main_video = 'gallery-videos/main/' . $mainVideoName;
            }

            // Ana video thumbnail güncelleme
            if ($request->hasFile('main_video_thumbnail')) {
                if ($galleryVideo->main_video_thumbnail) {
                    Storage::disk('public')->delete($galleryVideo->main_video_thumbnail);
                }
                $mainThumbnail = $request->file('main_video_thumbnail');
                $mainThumbnailName = time() . '_thumb_' . $mainThumbnail->getClientOriginalName();
                $mainThumbnail->storeAs('public/gallery-videos/thumbnails', $mainThumbnailName);
                $galleryVideo->main_video_thumbnail = 'gallery-videos/thumbnails/' . $mainThumbnailName;
            }

            // Alt video güncelleme
            if ($request->hasFile('bottom_video')) {
                if ($galleryVideo->bottom_video) {
                    Storage::disk('public')->delete($galleryVideo->bottom_video);
                }
                $bottomVideo = $request->file('bottom_video');
                $bottomVideoName = time() . '_' . $bottomVideo->getClientOriginalName();
                $bottomVideo->storeAs('public/gallery-videos/bottom', $bottomVideoName);
                $galleryVideo->bottom_video = 'gallery-videos/bottom/' . $bottomVideoName;
            }

            // Alt video thumbnail güncelleme
            if ($request->hasFile('bottom_video_thumbnail')) {
                if ($galleryVideo->bottom_video_thumbnail) {
                    Storage::disk('public')->delete($galleryVideo->bottom_video_thumbnail);
                }
                $bottomThumbnail = $request->file('bottom_video_thumbnail');
                $bottomThumbnailName = time() . '_thumb_' . $bottomThumbnail->getClientOriginalName();
                $bottomThumbnail->storeAs('public/gallery-videos/thumbnails', $bottomThumbnailName);
                $galleryVideo->bottom_video_thumbnail = 'gallery-videos/thumbnails/' . $bottomThumbnailName;
            }

            // Multiple videos işlemleri
            $multipleVideos = [];

            // Mevcut videoları kontrol et
            if ($request->has('existing_videos')) {
                $existingVideoUrls = $request->existing_videos;
                
                // Silinmiş videoları bul ve dosyaları sil
                foreach ($currentVideos as $currentVideo) {
                    if (!in_array($currentVideo['video'], $existingVideoUrls)) {
                        // Video ve thumbnail'ı sil
                        Storage::disk('public')->delete($currentVideo['video']);
                        if (!empty($currentVideo['thumbnail'])) {
                            Storage::disk('public')->delete($currentVideo['thumbnail']);
                        }
                    }
                }

                // Kalan videoları yeni listeye ekle
                foreach ($request->existing_videos as $key => $video) {
                    if (!empty($video)) {
                        // Mevcut video için eski thumbnail'ı bul
                        $oldVideo = collect($currentVideos)->firstWhere('video', $video);
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

            // Yeni videolar ekle
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $key => $video) {
                    $videoName = time() . '_' . $key . '_' . $video->getClientOriginalName();
                    $video->storeAs('public/gallery-videos/multiple', $videoName);
                    
                    $thumbnailName = null;
                    // Video thumbnail
                    if ($request->hasFile('videos_thumbnail') && isset($request->file('videos_thumbnail')[$key])) {
                        $thumbnail = $request->file('videos_thumbnail')[$key];
                        $thumbnailName = time() . '_thumb_' . $key . '_' . $thumbnail->getClientOriginalName();
                        $thumbnail->storeAs('public/gallery-videos/thumbnails', $thumbnailName);
                    }
                    
                    $multipleVideos[] = [
                        'video' => 'gallery-videos/multiple/' . $videoName,
                        'thumbnail' => $thumbnailName ? 'gallery-videos/thumbnails/' . $thumbnailName : '',
                        'alt_az' => $request->input('videos_alt_az.' . $key, ''),
                        'alt_en' => $request->input('videos_alt_en.' . $key, ''),
                        'alt_ru' => $request->input('videos_alt_ru.' . $key, '')
                    ];
                }
            }

            // Multiple videos'u güncelle
            if (!empty($multipleVideos)) {
                $galleryVideo->multiple_videos = $multipleVideos;
            }

            // Değişiklikleri kaydet
            if (!$galleryVideo->save()) {
                throw new \Exception('Güncelleme işlemi başarısız oldu.');
            }

            // Başarılı olduğunda index sayfasına yönlendir
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
            // Tüm videoları ve thumbnailları sil
            if ($galleryVideo->main_video) {
                Storage::disk('public')->delete($galleryVideo->main_video);
            }
            if ($galleryVideo->main_video_thumbnail) {
                Storage::disk('public')->delete($galleryVideo->main_video_thumbnail);
            }
            if ($galleryVideo->bottom_video) {
                Storage::disk('public')->delete($galleryVideo->bottom_video);
            }
            if ($galleryVideo->bottom_video_thumbnail) {
                Storage::disk('public')->delete($galleryVideo->bottom_video_thumbnail);
            }
            if (!empty($galleryVideo->multiple_videos)) {
                foreach ($galleryVideo->multiple_videos as $video) {
                    Storage::disk('public')->delete($video['video']);
                    Storage::disk('public')->delete($video['thumbnail']);
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

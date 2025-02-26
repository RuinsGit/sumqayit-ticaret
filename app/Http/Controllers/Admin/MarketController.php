<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Artisan::call('migrate');
        $markets = Market::latest()->get();
        return view('back.admin.market.index', compact('markets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.admin.market.create');
    }

    /**
     * Handle image upload and conversion
     */
    protected function handleImageUpload($file, $prefix = '')
    {
        $destinationPath = public_path('uploads/markets');
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // SVG dosyası kontrolü
        if ($file->getClientOriginalExtension() === 'svg') {
            $fileName = time() . '_' . $prefix . '_' . $originalFileName . '.svg';
            $file->move($destinationPath, $fileName);
            return 'uploads/markets/' . $fileName;
        } else {
            // Diğer resim formatları için webp dönüşümü
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

            throw new \Exception('Resim işlenirken bir hata oluştu.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_az' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_alt_az' => 'nullable|string|max:255',
            'image_alt_en' => 'nullable|string|max:255',
            'image_alt_ru' => 'nullable|string|max:255',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'), 'market');
        }

        Market::create($data);

        return redirect()->route('back.pages.market.index')
            ->with('success', 'Market uğurla əlavə edildi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Market $market)
    {
        return view('back.admin.market.edit', compact('market'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Market $market)
    {
        $request->validate([
            'name_az' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_alt_az' => 'nullable|string|max:255',
            'image_alt_en' => 'nullable|string|max:255',
            'image_alt_ru' => 'nullable|string|max:255',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($market->image) {
                $oldPath = public_path($market->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['image'] = $this->handleImageUpload($request->file('image'), 'market');
        }

        $market->update($data);

        return redirect()->route('back.pages.market.index')
            ->with('success', 'Market uğurla yeniləndi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Market $market)
    {
        // Delete image
        if ($market->image) {
            $path = public_path($market->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $market->delete();

        return redirect()->route('back.pages.market.index')
            ->with('success', 'Market uğurla silindi!');
    }
} 
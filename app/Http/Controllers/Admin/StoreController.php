<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreType;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::with('storeType')->latest()->get();
        return view('back.admin.store.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $storeTypes = StoreType::where('status', 1)->get();
        $markets = Market::where('status', 1)->get();
        return view('back.admin.store.create', compact('storeTypes', 'markets'));
    }

    /**
     * Handle image upload and conversion
     */
    protected function handleImageUpload($file, $prefix = '')
    {
        $destinationPath = public_path('uploads/stores');
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // SVG dosyası kontrolü
        if ($file->getClientOriginalExtension() === 'svg') {
            $fileName = time() . '_' . $prefix . '_' . $originalFileName . '.svg';
            $file->move($destinationPath, $fileName);
            return 'uploads/stores/' . $fileName;
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
                return 'uploads/stores/' . $webpFileName;
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
            'store_type_id' => 'required|exists:store_types,id',
            'market_id' => 'nullable|exists:markets,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_alt_az' => 'nullable|string',
            'image_alt_en' => 'nullable|string',
            'image_alt_ru' => 'nullable|string',
            'bottom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'bottom_image_alt_az' => 'nullable|string',
            'bottom_image_alt_en' => 'nullable|string',
            'bottom_image_alt_ru' => 'nullable|string',
            'description_az' => 'required|string',
            'description_en' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'working_hours_az' => 'required|string',
            'working_hours_en' => 'nullable|string',
            'working_hours_ru' => 'nullable|string',
            'working_hours_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'number' => 'required|string',
            'number_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'email' => 'required|email',
            'email_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link' => 'nullable|url',
            'link_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        // Handle main images (WebP conversion)
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'), 'main');
        }
        if ($request->hasFile('bottom_image')) {
            $data['bottom_image'] = $this->handleImageUpload($request->file('bottom_image'), 'bottom');
        }

        // Handle icon images (SVG or WebP)
        $iconFields = ['working_hours_image', 'number_image', 'email_image', 'link_image'];
        foreach ($iconFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $this->handleImageUpload($request->file($field), str_replace('_image', '', $field));
            }
        }

        Store::create($data);

        return redirect()->route('back.pages.store.index')
            ->with('success', 'Mağaza uğurla əlavə edildi!');
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
    public function edit(Store $store)
    {
        $storeTypes = StoreType::where('status', 1)->get();
        $markets = Market::where('status', 1)->get();
        return view('back.admin.store.edit', compact('store', 'storeTypes', 'markets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'store_type_id' => 'required|exists:store_types,id',
            'market_id' => 'nullable|exists:markets,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_alt_az' => 'nullable|string',
            'image_alt_en' => 'nullable|string',
            'image_alt_ru' => 'nullable|string',
            'bottom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'bottom_image_alt_az' => 'nullable|string',
            'bottom_image_alt_en' => 'nullable|string',
            'bottom_image_alt_ru' => 'nullable|string',
            'description_az' => 'required|string',
            'description_en' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'working_hours_az' => 'required|string',
            'working_hours_en' => 'nullable|string',
            'working_hours_ru' => 'nullable|string',
            'working_hours_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'number' => 'required|string',
            'number_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'email' => 'required|email',
            'email_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link' => 'nullable|url',
            'link_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        // Handle main images (WebP conversion)
        if ($request->hasFile('image')) {
            if ($store->image) {
                $oldPath = public_path($store->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['image'] = $this->handleImageUpload($request->file('image'), 'main');
        }
        if ($request->hasFile('bottom_image')) {
            if ($store->bottom_image) {
                $oldPath = public_path($store->bottom_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['bottom_image'] = $this->handleImageUpload($request->file('bottom_image'), 'bottom');
        }

        // Handle icon images (SVG or WebP)
        $iconFields = ['working_hours_image', 'number_image', 'email_image', 'link_image'];
        foreach ($iconFields as $field) {
            if ($request->hasFile($field)) {
                if ($store->$field) {
                    $oldPath = public_path($store->$field);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $data[$field] = $this->handleImageUpload($request->file($field), str_replace('_image', '', $field));
            }
        }

        $store->update($data);

        return redirect()->route('back.pages.store.index')
            ->with('success', 'Mağaza uğurla yeniləndi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        // Delete all associated images
        $imageFields = ['image', 'bottom_image', 'working_hours_image', 'number_image', 'email_image', 'link_image'];
        foreach ($imageFields as $field) {
            if ($store->$field) {
                $path = public_path($store->$field);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        $store->delete();

        return redirect()->route('back.pages.store.index')
            ->with('success', 'Mağaza uğurla silindi!');
    }
}

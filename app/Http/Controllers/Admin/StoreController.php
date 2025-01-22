<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreType;
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
        return view('back.admin.store.create', compact('storeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'store_type_id' => 'required|exists:store_types,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_alt_az' => 'nullable|string',
            'image_alt_en' => 'nullable|string',
            'image_alt_ru' => 'nullable|string',
            'bottom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bottom_image_alt_az' => 'nullable|string',
            'bottom_image_alt_en' => 'nullable|string',
            'bottom_image_alt_ru' => 'nullable|string',
            'description_az' => 'required|string',
            'description_en' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'working_hours_az' => 'required|string',
            'working_hours_en' => 'nullable|string',
            'working_hours_ru' => 'nullable|string',
            'working_hours_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'number' => 'required|string',
            'number_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email',
            'email_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'link_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        // Handle image uploads
        $imageFields = ['image', 'bottom_image', 'working_hours_image', 'number_image', 'email_image', 'link_image'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('stores', 'public');
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
        return view('back.admin.store.edit', compact('store', 'storeTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'store_type_id' => 'required|exists:store_types,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_alt_az' => 'nullable|string',
            'image_alt_en' => 'nullable|string',
            'image_alt_ru' => 'nullable|string',
            'bottom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bottom_image_alt_az' => 'nullable|string',
            'bottom_image_alt_en' => 'nullable|string',
            'bottom_image_alt_ru' => 'nullable|string',
            'description_az' => 'required|string',
            'description_en' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'working_hours_az' => 'required|string',
            'working_hours_en' => 'nullable|string',
            'working_hours_ru' => 'nullable|string',
            'working_hours_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'number' => 'required|string',
            'number_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email',
            'email_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'link_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        // Handle image uploads
        $imageFields = ['image', 'bottom_image', 'working_hours_image', 'number_image', 'email_image', 'link_image'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if exists
                if ($store->$field) {
                    Storage::disk('public')->delete($store->$field);
                }
                $data[$field] = $request->file($field)->store('stores', 'public');
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
        // Delete associated images
        $imageFields = ['image', 'bottom_image', 'working_hours_image', 'number_image', 'email_image', 'link_image'];
        foreach ($imageFields as $field) {
            if ($store->$field) {
                Storage::disk('public')->delete($store->$field);
            }
        }

        $store->delete();

        return redirect()->route('back.pages.store.index')
            ->with('success', 'Mağaza uğurla silindi!');
    }
}

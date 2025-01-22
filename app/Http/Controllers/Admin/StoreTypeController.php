<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class StoreTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Artisan::call('migrate');
        $storeTypes = StoreType::latest()->get();
        return view('back.admin.store-type.index', compact('storeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.admin.store-type.create');
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
            'status' => 'required|boolean'
        ]);

        StoreType::create($request->all());

        return redirect()->route('back.pages.store-type.index')
            ->with('success', 'Mağaza növü uğurla əlavə edildi!');
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
    public function edit(StoreType $storeType)
    {
        return view('back.admin.store-type.edit', compact('storeType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StoreType $storeType)
    {
        $request->validate([
            'name_az' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'status' => 'required|boolean'
        ]);

        $storeType->update($request->all());

        return redirect()->route('back.pages.store-type.index')
            ->with('success', 'Mağaza növü uğurla yeniləndi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreType $storeType)
    {
        $storeType->delete();

        return redirect()->route('back.pages.store-type.index')
            ->with('success', 'Mağaza növü uğurla silindi!');
    }
}

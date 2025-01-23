<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return response()->json([
            'data' => ServiceResource::collection($services),
            
        ]);
    
    }

    public function show(Service $service)
    {
        return new ServiceResource($service);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_az' => 'required',
            'title_en' => 'required',
            'title_ru' => 'required',
            'description_az' => 'required',
            'description_en' => 'required',
            'description_ru' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'bottom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        $data = $request->all();
            

        $service = Service::create($data);
        return new ServiceResource($service);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title_az' => 'required',
            'title_en' => 'required',
            'title_ru' => 'required',
            'description_az' => 'required',
            'description_en' => 'required',
            'description_ru' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'bottom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        $data = $request->all();
            

        $service->update($data);
        return new ServiceResource($service);
    }

    public function destroy(Service $service)
    {
        

        return response()->json(['message' => 'Xidmət uğurla silindi.'], 204);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactfooterResource;
use App\Models\Contactfooter;
use Illuminate\Http\Request;

class ContactfooterApiController extends Controller
{
    public function index()
    {
        $contactfooter = Contactfooter::first();
        if (!$contactfooter) {
            return response()->json(['message' => 'No Contactfooters found'], 404);
        }
        return new ContactfooterResource($contactfooter);
    }

    public function show($id)
    {
        $contactfooter = Contactfooter::find($id);
        if (!$contactfooter) {
            return response()->json(['message' => 'Contactfooter not found'], 404);
        }
        return new ContactfooterResource($contactfooter);
    }

    public function store(Request $request)
    {
        if (Contactfooter::count() >= 1) {
            return response()->json(['error' => 'Hal-hazırda bir əlaqə mövcuddur. Yeni bir əlaqə əlavə edə bilməzsiniz.'], 400);
        }

        $data = $request->validate([
            'number' => 'required|string|max:255',
            'number_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'mail' => 'required|email|max:255',
            'mail_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'address_az' => 'required|string|max:255',
            'address_en' => 'required|string|max:255',
            'address_ru' => 'required|string|max:255',
            'address_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'filial_description' => 'nullable|string',
        ]);

        $data = $this->uploadImages($request, $data);

        $contactfooter = Contactfooter::create($data);

        return response()->json(['message' => 'Əlaqə uğurla yaradıldı', 'data' => new ContactfooterResource($contactfooter)], 201);
    }

    public function update(Request $request, $id)
    {
        $contactfooter = Contactfooter::findOrFail($id);

        $data = $request->validate([
            'number' => 'required|string|max:255',
            'number_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'mail' => 'required|email|max:255',
            'mail_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'address_az' => 'required|string|max:255',
            'address_en' => 'required|string|max:255',
            'address_ru' => 'required|string|max:255',
            'address_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'filial_description' => 'nullable|string',
        ]);

        $data = $this->uploadImages($request, $data, $contactfooter);

        $contactfooter->update($data);

        return response()->json(['message' => 'Əlaqə uğurla yeniləndi', 'data' => new ContactfooterResource($contactfooter)], 200);
    }

    public function destroy($id)
    {
        $contactfooter = Contactfooter::findOrFail($id);
        
        $this->deleteImages($contactfooter);

        $contactfooter->delete();

        return response()->json(['message' => 'Əlaqə uğurla silindi'], 200);
    }

    private function uploadImages(Request $request, array $data, Contactfooter $contactfooter = null)
    {
        if ($request->hasFile('number_image')) {
            if ($contactfooter && $contactfooter->number_image) {
                $this->deleteFile($contactfooter->number_image);
            }
            $data['number_image'] = $this->saveImage($request->file('number_image'));
        }

        if ($request->hasFile('mail_image')) {
            if ($contactfooter && $contactfooter->mail_image) {
                $this->deleteFile($contactfooter->mail_image);
            }
            $data['mail_image'] = $this->saveImage($request->file('mail_image'));
        }

        if ($request->hasFile('address_image')) {
            if ($contactfooter && $contactfooter->address_image) {
                $this->deleteFile($contactfooter->address_image);
            }
            $data['address_image'] = $this->saveImage($request->file('address_image'));
        }

        return $data;
    }

    private function saveImage($file)
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $webpFileName = time() . '_' . $originalFileName . '.webp';
        $webpPath = public_path('uploads/' . $webpFileName);

        $imageResource = imagecreatefromstring(file_get_contents($file));
        if ($imageResource) {
            imagewebp($imageResource, $webpPath, 80);
            imagedestroy($imageResource);
            return 'uploads/' . $webpFileName;
        }

        return null;
    }

    private function deleteFile($filePath)
    {
        $fullPath = public_path($filePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    private function deleteImages(Contactfooter $contactfooter)
    {
        $this->deleteFile($contactfooter->number_image);
        $this->deleteFile($contactfooter->mail_image);
        $this->deleteFile($contactfooter->address_image);
    }
} 
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contactfooter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ContactfooterController extends Controller
{

    private $destinationPath;
    protected $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/svg+xml',
        'image/webp',
        'application/svg+xml',
        'application/svg',
    ];

    public function __construct()
    {
        Artisan::call('migrate');
        $this->destinationPath = public_path('uploads');
    }

    protected function handleImageUpload($file, $prefix = '')
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        if ($file->getClientOriginalExtension() === 'svg') {
            $fileName = time() . '_' . $prefix . '_' . $originalFileName . '.svg';
            $file->move($this->destinationPath, $fileName);
            return 'uploads/' . $fileName;
        } else {
            $webpFileName = time() . '_' . $prefix . '_' . $originalFileName . '.webp';

            if (!file_exists($this->destinationPath)) {
                mkdir($this->destinationPath, 0777, true);
            }

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $this->destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                return 'uploads/' . $webpFileName;
            }

            throw new \Exception('Resim işlenirken bir hata oluştu.');
        }
    }

    public function index()
    {
        $contactfooters = Contactfooter::all();
        return view('back.pages.contactfooter.index', compact('contactfooters'));
    }

    public function create()
    {
        if(Contactfooter::count() > 0) {
            return redirect()->route('back.pages.contactfooter.index')
                ->with('error', 'Maksimum 1 əlaqə məlumatı əlavə edilə bilər');
        }
        return view('back.pages.contactfooter.create');
    }

    public function store(Request $request)
    {
        if(Contactfooter::count() > 0) {
            return redirect()->route('back.pages.contactfooter.index')
                ->with('error', 'Maksimum 1 əlaqə məlumatı əlavə edilə bilər');
        }
        
        $data = $request->validate([
            'number' => 'required|string|max:255',
            'number_image' => 'nullable|mimes:jpeg,png,jpg,svg,webp',
            'mail' => 'required|email|max:255',
            'mail_image' => 'nullable|mimes:jpeg,png,jpg,svg,webp',
            'address_az' => 'required|string|max:255',
            'address_en' => 'required|string|max:255',
            'address_ru' => 'required|string|max:255',
            'address_image' => 'nullable|mimes:jpeg,png,jpg,svg,webp',
            'filial_description' => 'nullable|string',
        ]);

        try {
            // Number Image
            if ($request->hasFile('number_image')) {
                $file = $request->file('number_image');
                if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
                    return redirect()->back()->withErrors(['number_image' => 'Desteklenmeyen dosya formatı. Lütfen JPG, JPEG, PNG, GIF, SVG veya WEBP formatında bir dosya yükleyin.']);
                }
                $data['number_image'] = $this->handleImageUpload($file, 'number');
            }

            // Mail Image
            if ($request->hasFile('mail_image')) {
                $file = $request->file('mail_image');
                if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
                    return redirect()->back()->withErrors(['mail_image' => 'Desteklenmeyen dosya formatı. Lütfen JPG, JPEG, PNG, GIF, SVG veya WEBP formatında bir dosya yükleyin.']);
                }
                $data['mail_image'] = $this->handleImageUpload($file, 'mail');
            }

            // Address Image
            if ($request->hasFile('address_image')) {
                $file = $request->file('address_image');
                if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
                    return redirect()->back()->withErrors(['address_image' => 'Desteklenmeyen dosya formatı. Lütfen JPG, JPEG, PNG, GIF, SVG veya WEBP formatında bir dosya yükleyin.']);
                }
                $data['address_image'] = $this->handleImageUpload($file, 'address');
            }

            Contactfooter::create($data);

            return redirect()->route('back.pages.contactfooter.index')->with('success', 'Əlaqə məlumatları uğurla əlavə edildi.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Resim işlenirken bir hata oluştu: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $contactfooter = Contactfooter::findOrFail($id);
        return view('back.pages.contactfooter.edit', compact('contactfooter'));
    }

    public function update(Request $request, $id)
    {
        $contactfooter = Contactfooter::findOrFail($id);

        $data = $request->validate([
            'number' => 'required|string|max:255',
            'number_image' => 'nullable|mimes:jpeg,png,jpg,svg,webp',
            'mail' => 'required|email|max:255',
            'mail_image' => 'nullable|mimes:jpeg,png,jpg,svg,webp',
            'address_az' => 'required|string|max:255',
            'address_en' => 'required|string|max:255',
            'address_ru' => 'required|string|max:255',
            'address_image' => 'nullable|mimes:jpeg,png,jpg,svg,webp',
            'filial_description' => 'nullable|string',
        ]);

        try {
            
            if ($request->hasFile('number_image')) {
                $file = $request->file('number_image');
                if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
                    return redirect()->back()->withErrors(['number_image' => 'Desteklenmeyen dosya formatı. Lütfen JPG, JPEG, PNG, GIF, SVG veya WEBP formatında bir dosya yükleyin.']);
                }

                if ($contactfooter->number_image) {
                    $oldImagePath = public_path($contactfooter->number_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $data['number_image'] = $this->handleImageUpload($file, 'number');
            }

            if ($request->hasFile('mail_image')) {
                $file = $request->file('mail_image');
                if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
                    return redirect()->back()->withErrors(['mail_image' => 'Desteklenmeyen dosya formatı. Lütfen JPG, JPEG, PNG, GIF, SVG veya WEBP formatında bir dosya yükleyin.']);
                }

                if ($contactfooter->mail_image) {
                    $oldImagePath = public_path($contactfooter->mail_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $data['mail_image'] = $this->handleImageUpload($file, 'mail');
            }

            if ($request->hasFile('address_image')) {
                $file = $request->file('address_image');
                if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
                    return redirect()->back()->withErrors(['address_image' => 'Desteklenmeyen dosya formatı. Lütfen JPG, JPEG, PNG, GIF, SVG veya WEBP formatında bir dosya yükleyin.']);
                }

                if ($contactfooter->address_image) {
                    $oldImagePath = public_path($contactfooter->address_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $data['address_image'] = $this->handleImageUpload($file, 'address');
            }

            $contactfooter->update($data);

            return redirect()->route('back.pages.contactfooter.index')->with('success', 'Əlaqə məlumatları uğurla yeniləndi.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Resim işlenirken bir hata oluştu: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $contactfooter = Contactfooter::findOrFail($id);
        
        if ($contactfooter->number_image) {
            $imagePath = public_path($contactfooter->number_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($contactfooter->mail_image) {
            $imagePath = public_path($contactfooter->mail_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($contactfooter->address_image) {
            $imagePath = public_path($contactfooter->address_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $contactfooter->delete();

        return redirect()->route('back.pages.contactfooter.index')->with('success', 'Əlaqə məlumatları uğurla silindi.');
    }
} 
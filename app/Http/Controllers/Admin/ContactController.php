<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $destinationPath;

    public function __construct()
    {
        $this->destinationPath = public_path('uploads');
    }

    public function index()
    {
        $contacts = Contact::all();
        return view('back.pages.contact.index', compact('contacts'));
    }

    public function create()
    {
        if(Contact::count() > 0) {
            return redirect()->route('back.pages.contact.index')
                ->with('error', 'Maksimum 1 əlaqə məlumatı əlavə edilə bilər');
        }
        return view('back.pages.contact.create');
    }

    public function store(Request $request)
    {
        if(Contact::count() > 0) {
            return redirect()->route('back.pages.contact.index')
                ->with('error', 'Maksimum 1 əlaqə məlumatı əlavə edilə bilər');
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
            'work_hours' => 'required|string|max:255',
            'work_hours_image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        // Number Image
        if ($request->hasFile('number_image')) {
            $file = $request->file('number_image');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $this->destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                $data['number_image'] = 'uploads/' . $webpFileName;
            }
        }

        // Mail Image
        if ($request->hasFile('mail_image')) {
            $file = $request->file('mail_image');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $this->destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                $data['mail_image'] = 'uploads/' . $webpFileName;
            }
        }

        // Address Image
        if ($request->hasFile('address_image')) {
            $file = $request->file('address_image');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $this->destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                $data['address_image'] = 'uploads/' . $webpFileName;
            }
        }

        // Work Hours Image
        if ($request->hasFile('work_hours_image')) {
            $file = $request->file('work_hours_image');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $this->destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                $data['work_hours_image'] = 'uploads/' . $webpFileName;
            }
        }

        Contact::create($data);

        return redirect()->route('back.pages.contact.index')->with('success', 'Əlaqə məlumatları uğurla əlavə edildi.');
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('back.pages.contact.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

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
            'work_hours' => 'required|string|max:255',
            'work_hours_image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        // Number Image
        if ($request->hasFile('number_image')) {
            if ($contact->number_image) {
                $oldImagePath = public_path($contact->number_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('number_image');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $this->destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                $data['number_image'] = 'uploads/' . $webpFileName;
            }
        }

        // Mail Image
        if ($request->hasFile('mail_image')) {
            if ($contact->mail_image) {
                $oldImagePath = public_path($contact->mail_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('mail_image');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $this->destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                $data['mail_image'] = 'uploads/' . $webpFileName;
            }
        }

        // Address Image
        if ($request->hasFile('address_image')) {
            if ($contact->address_image) {
                $oldImagePath = public_path($contact->address_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('address_image');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $this->destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                $data['address_image'] = 'uploads/' . $webpFileName;
            }
        }

        // Work Hours Image
        if ($request->hasFile('work_hours_image')) {
            if ($contact->work_hours_image) {
                $oldImagePath = public_path($contact->work_hours_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('work_hours_image');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFileName = time() . '_' . $originalFileName . '.webp';

            $imageResource = imagecreatefromstring(file_get_contents($file));
            $webpPath = $this->destinationPath . '/' . $webpFileName;

            if ($imageResource) {
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);
                $data['work_hours_image'] = 'uploads/' . $webpFileName;
            }
        }

        $contact->update($data);

        return redirect()->route('back.pages.contact.index')->with('success', 'Əlaqə məlumatları uğurla yeniləndi.');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Delete images if they exist
        if ($contact->number_image) {
            $imagePath = public_path($contact->number_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($contact->mail_image) {
            $imagePath = public_path($contact->mail_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($contact->address_image) {
            $imagePath = public_path($contact->address_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($contact->work_hours_image) {
            $imagePath = public_path($contact->work_hours_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $contact->delete();

        return redirect()->route('back.pages.contact.index')->with('success', 'Əlaqə məlumatları uğurla silindi.');
    }
} 
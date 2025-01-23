<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ContactRentController extends Controller
{
    public function index()
    {
        Artisan::call('migrate');
        $contacts = ContactRent::orderBy('created_at', 'desc')->paginate(10);
        return view('back.pages.contact-rent.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contact_rent.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_prefix' => 'required|string|max:10',
            'phone_number' => 'required|string|max:20',
            'warehouse' => 'required|string|max:255',
            'requested_area' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        ContactRent::create($request->all());
        return redirect()->route('admin.contact_rent.index')->with('success', 'Contact added successfully!');
    }

    public function show($id)
    {
        $contact = ContactRent::findOrFail($id);
        return view('back.pages.contact-rent.show', compact('contact'));
    }

    public function edit($id)
    {
        $contact = ContactRent::findOrFail($id);
        return view('admin.contact_rent.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_prefix' => 'required|string|max:10',
            'phone_number' => 'required|string|max:20',
            'warehouse' => 'required|string|max:255',
            'requested_area' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        $contact = ContactRent::findOrFail($id);
        $contact->update($request->all());
        return redirect()->route('admin.contact_rent.index')->with('success', 'Contact updated successfully!');
    }

    public function destroy($id)
    {
        $contact = ContactRent::findOrFail($id);
        $contact->delete();
        
        return redirect()->route('back.pages.contact-rent.index')
            ->with('success', 'Müraciət uğurla silindi.');
    }
}

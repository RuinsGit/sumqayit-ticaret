<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactRent;
use Illuminate\Http\Request;

class ContactRentApiController extends Controller
{
    public function index()
    {
        $contacts = ContactRent::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($contacts);
    }

    public function show($id)
    {
        $contact = ContactRent::find($id);
        
        if (!$contact) {
            return response()->json(['message' => 'Kiralama talebi bulunamadı.'], 404);
        }

        return response()->json($contact);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_prefix' => 'required|string|max:10',
            'phone_number' => 'required|string|max:15',
            'warehouse' => 'required|string|max:255',
            'requested_area' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        $contact = ContactRent::create($request->all());
        return response()->json($contact, 201);
    }

    public function destroy($id)
    {
        $contact = ContactRent::find($id);
        
        if (!$contact) {
            return response()->json(['message' => 'Kiralama talebi bulunamadı.'], 404);
        }

        $contact->delete();
        return response()->json(['message' => 'Kiralama talebi başarıyla silindi.']);
    }
} 
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactRent;
use App\Mail\ContactRentMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\ContactRentResource;

class ContactRentApiController extends Controller
{
    public function index()
    {
        try {
            $contacts = ContactRent::latest()->paginate(10);
            return response()->json([
                'status' => 'success',
                'data' => ContactRentResource::collection($contacts)
            ], 200);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'brand_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone_prefix' => 'required|string|max:10',
                'phone_number' => 'required|string|max:15',
                'warehouse' => 'required|string|max:255',
                'requested_area' => 'required|string|max:255',
                'message' => 'nullable|string',
            ]);

            DB::beginTransaction();
            
            $contact = ContactRent::create($validated);

            try {
                
                Mail::to('museyibli.ruhin@gmail.com')->send(new ContactRentMail($contact));

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Kiraye uğurla göndərildi',
                    'data' => new ContactRentResource($contact)
                ], 201);

            } catch (\Exception $e) {
                DB::commit();
                
                \Log::error('Mail gönderme hatası: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Kiraye kaydedildi, ancak mail gönderilirken hata oluştu',
                    'data' => new ContactRentResource($contact),
                    'mail_error' => $e->getMessage()
                ], 500);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Bir xəta baş verdi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $contact = ContactRent::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => new ContactRentResource($contact)
            ], 200);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 'Kiraye telebi Tapılmadı', 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'brand_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'phone_prefix' => 'sometimes|string|max:10',
            'phone_number' => 'sometimes|string|max:15',
            'warehouse' => 'sometimes|string|max:255',
            'requested_area' => 'sometimes|string|max:255',
            'message' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contact = ContactRent::findOrFail($id);
            $contact->update($request->all());
            
            return response()->json([
                'status' => 'success',
                'data' => new ContactRentResource($contact)
            ], 200);

        } catch (\Exception $e) {
            return $this->sendErrorResponse($e);
        }
    }

    public function destroy($id)
    {
        try {
            $contact = ContactRent::findOrFail($id);
            $contact->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Kiraye telebi uğurla silindi'
            ], 204);

        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 'Silme işlemi başarısız', 500);
        }
    }

    private function sendErrorResponse(\Exception $e, $message = 'Server error', $code = 500)
    {
        if (config('app.debug')) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], $code);
        }

        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
} 
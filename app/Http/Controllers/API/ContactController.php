<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Log the incoming request data
        Log::info('Contact form submission:', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            $contact = ContactForm::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            ]);

            DB::commit();
            
            Log::info('Contact form created successfully:', $contact->toArray());

            return response()->json([
                'status' => true,
                'message' => 'Message sent successfully',
                'data' => $contact
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating contact form:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => false,
                'message' => 'Failed to save message',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

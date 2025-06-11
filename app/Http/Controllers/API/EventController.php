<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function publicEvents()
    {
        $events = Event::where('is_public', true)
            ->latest()
            ->take(5)
            ->get();
    
        return response()->json(['events' => $events]);
    }
    public function index(Request $request)
    {
        $user = $request->user();
        $events = $user->events()->latest()->get();
    
        return response()->json([
            'status' => true,
            'message' => "User's events",
            'events' => $events
        ]);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png',
            'type' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string',
            'is_public' => 'nullable|boolean',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $filePath = $request->file('image')->getRealPath();

        $uploadResult = Cloudinary::uploadApi()->upload($filePath, [
            'folder' => 'events',
        ]);
    
        $url = $uploadResult['secure_url'];
        $public_id = $uploadResult['public_id'];
    
        $event = $request->user()->events()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $url,
            'cloudinary_public_id' => $public_id,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'type' => $request->type ?? 'general',
            'date' => $request->date ?? now(),
            'location' => $request->location ?? 'Unknown',
            'is_public' => $request->input('is_public') == '1',
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'Event created successfully',
            'event' => $event,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $data['event'] = Event::where('id', $id)->get();
        return response()->json([
            'status' => true,
            'message' => "Event Loaded successfully",
            'event' => $data,
        ], 200);
    }

    public function showPublic(string $id)
    {
        $event = Event::where('id', $id)
            ->where('is_public', true)
            ->first();

        if (!$event) {
            return response()->json([
                'status' => false,
                'message' => "Public event not found",
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Public event loaded successfully",
            'event' => $event,
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $validator = Validator::make(
        $request->all(),
        [
            'title' => 'required',
            'description' => 'required',
            'lat' => 'required',
            'lon' => 'required',
            'date' => 'required',
            'is_public' => 'nullable|boolean',
            'location' => 'required',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
        ]
    );

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => "Validation error",
            'errors' => $validator->errors(),
        ], 422);
    }

        $user = $request->user();
        $event = Event::where('id', $id)->where('user_id', $user->id)->first();

        if (!$event) {
            return response()->json([
                'status' => false,
                'message' => "Event not found or unauthorized",
            ], 404);
        }

        // If new image provided, upload new image and delete old from Cloudinary
        if ($request->hasFile('image')) {
            // Delete old image from Cloudinary if public_id exists
            if (!empty($event->cloudinary_public_id)) {
                Cloudinary::uploadApi()->destroy($event->cloudinary_public_id);
            }

            $filePath = $request->file('image')->getRealPath();
            $uploadResult = Cloudinary::uploadApi()->upload($filePath, [
                'folder' => 'events',
            ]);

            $url = $uploadResult['secure_url'];
            $public_id = $uploadResult['public_id'];

            $event->image_url = $url;
            $event->cloudinary_public_id = $public_id;
        }

        // Update other fields
        $event->title = $request->title;
        $event->description = $request->description;
        $event->lat = $request->lat;
        $event->lon = $request->lon;
        $event->date = $request->date;
        $event->is_public = $request->input('is_public', $event->is_public);
        $event->location = $request->location;

        $event->save();

        return response()->json([
            'status' => true,
            'message' => "Event updated successfully",
            'event' => $event,
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = $request->user();

        $event = Event::where('id', $id)->where('user_id', $user->id)->first();

        if (!$event) {
            return response()->json([
                'status' => false,
                'message' => "Event not found or you don't have permission to delete it",
            ], 403);
        }

        // Delete image from Cloudinary if public_id exists
        if (!empty($event->cloudinary_public_id)) {
            Cloudinary::uploadApi()->destroy($event->cloudinary_public_id);
        }

        $event->delete();

        return response()->json([
            'status' => true,
            'message' => "Event deleted successfully",
        ], 200);
    }
}

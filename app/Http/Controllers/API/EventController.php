<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $data['events'] = $user->events;
        // $data['events'] = Event::all();
        return response()->json([
            'status' => true,
            'message' => "All post data",
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'name' => 'required',
                'description' => 'required',
                'image' => 'required|file|mimes:jpg,jpeg,png',
                'lat' => 'required',
                'lon' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Cannot Store the Events in the DB::Validation error",
                "error" => $validator->errors()->all()
            ], 300);
        }
        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move(public_path() . '/uploads', $imageName);

        $user = $request->user();
        $event = new Event([
            'name' => $request->title,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'lat' => $request->lat,
            'lon' => $request->lon,
        ]);
        $user->events()->save($event);
        return response()->json([
            'status' => true,
            'message' => "Event created successfully",
            'event' => $event,
        ], 200);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->name);
        // $eventImage = Event::find($id);
        // dd($eventImage);


        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'title' => 'required',
                'description' => 'required',
                'image' => 'nullable|file|mimes:jpg,jpeg,png',
                'lat' => 'required',
                'lon' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Cannot Update the Events in the DB::Validation error",
                "error" => $validator->errors()
            ], 300);
        }

        $eventImage = Event::select('id', 'image')->where('id', $id)->get();
        // $eventImage = Event::find($id);
        // dd($eventImage);
        // if ($request->image != '') {
        if ($request->hasFile('image')) {
            $path = public_path() . '/uploads';
            if ($eventImage[0]['image'] != '' && !$eventImage[0]['image']) {
                $old_file = $path . $eventImage[0]['image'];
                if (file_exists($old_file)) {
                    unlink(filename: $old_file);
                }
            }
            $img = $request->image;
            $ext = $img->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $img->move(public_path() . '/uploads', $imageName);
        } else {
            $imageName = $eventImage[0]['image'];
        }
        //Now Updating here
        $user = $request->user();
        $event = Event::where('id', $id)
            ->where('user_id', $user->id) // 🔐 Ensure it's the user's own event
            ->first();
        $event->update([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'lat' => $request->lat,
            'lon' => $request->lon,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Event Updated successfully",
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

        $filePath = public_path('/uploads/' . $event->image);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $event->delete();
        return response()->json([
            'status' => true,
            'message' => "Event deleted successfully",
        ], 200);
    }
}

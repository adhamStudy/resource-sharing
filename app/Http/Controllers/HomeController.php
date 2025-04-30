<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Reservation;
class HomeController extends Controller
{
   public function index(){
    // dd(Auth::user());
    return inertia('Home');
   }


public function resource()
{


  

    $resources=Resource::all();
    // dd($resources);

    return inertia('Resources', [
        'resources' => $resources
    ]);
}
public function create(){
    return inertia('Create');
}

public function store(Request $request)
{
    // dd(Auth::id());
    $validated = $request->validate([
        'title'       => 'string|required',
        'description' => 'string|required',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    if ($request->hasFile('image')) {
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images', $imageName, 'public');
        $validated['image'] = 'storage/' . $path;
    }
    $validated['user_id'] = Auth::id();
    Resource::create($validated);

    return redirect()->route('resource')->with('success', 'Resource was Created');
}

public function show(Resource $resource)
{
    $user=User::where('id',$resource->user_id)->first();
    // dd($resource); // Check if the model is resolved correctly
    return inertia('Show', [
        'resource' => $resource,
        'user' => $user,
    ]);

}

public function reserve(Request $request, Resource $resource)
    {
        // Check if resource is available
        if (!$resource->is_available) {
            return response()->json([
                'message' => 'This resource is not available for reservation.'
            ], 422);
        }
        
        // Create a new reservation
        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->resource_id = $resource->id;
        $reservation->start_date = now();
        $reservation->end_date = now()->addDays(7); // Example: reserve for 7 days
        // You can add more fields like reservation end date, status, etc.
        $reservation->save();
        
        // Update resource availability
        $resource->is_available = false;
        $resource->save();
        
        return redirect()->route('resource')->with('success', 'Resource was reserved');

    }
}
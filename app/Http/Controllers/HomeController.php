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


   public function resource(Request $request)
   {
       $query = Resource::query()->with('reservations.user');
       
       // Search by name
       if ($request->has('search')) {
           $query->where('title', 'like', '%' . $request->search . '%');
       }
       
       // Filter by availability
       if ($request->has('availability')) {
           if ($request->availability === 'available') {
               $query->where('is_available', true);
           } else if ($request->availability === 'unavailable') {
               $query->where('is_available', false);
           }
       }
       
       // Sort options
       $sortBy = $request->sort_by ?? 'created_at';
       $sortDirection = $request->sort_direction ?? 'desc';
       $query->orderBy($sortBy, $sortDirection);
       
       $resources = $query->get();
       
       // Calculate days since reservation for unavailable resources
       // Add reservation information for unavailable resources
        foreach ($resources as $resource) {
            if (!$resource->is_available && $resource->reservations->count() > 0) {
                $latestReservation = $resource->reservations->sortByDesc('created_at')->first();
                
                // Fix: Format the time difference properly
                $daysSinceReservation = now()->diffInDays($latestReservation->created_at);
                
                // If less than 1 day, show in hours
                if ($daysSinceReservation < 1) {
                    $hoursSinceReservation = now()->diffInHours($latestReservation->created_at);
                    $resource->time_since_reservation = $hoursSinceReservation;
                    $resource->time_unit = 'hour';
                } else {
                    $resource->time_since_reservation = $daysSinceReservation;
                    $resource->time_unit = 'day';
                }
                
                $resource->reserved_by = $latestReservation->user;
            }
        }
        // dd($resources);
       
       return inertia('Resources', [
           'resources' => $resources,
           'filters' => [
               'search' => $request->search ?? '',
               'availability' => $request->availability ?? 'all',
               'sort_by' => $sortBy,
               'sort_direction' => $sortDirection
           ]
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
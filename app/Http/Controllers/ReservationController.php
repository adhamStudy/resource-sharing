<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Resource;
use App\Models\User;

class ReservationController extends Controller
{   
    public function index()
{
    $reservations = Reservation::with(['user', 'owner', 'resource.owner'])
        ->where('user_id', Auth::id())
        ->get();

    return inertia('MyReservations', [
        'reservations' => $reservations
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
    $reservation->user_id = Auth::id(); // current user making the reservation
    $reservation->resource_id = $resource->id;
    $reservation->owner_id = $resource->user_id; // owner of the resource

    // Optional: You may get these from the request
    $reservation->start_date = now()->toDateString();
    $reservation->end_date = now()->addDays(7)->toDateString(); // example duration

    $reservation->save();

    // Update resource availability
    $resource->is_available = false;
    $resource->save();

    return redirect()
        ->route('resource') // or 'resources.show' if you want to show one
        ->with('success', 'Resource was reserved successfully!');
}

public function release(Resource $resource)
{
    // Check if the current user owns the reservation
    $reservation = Reservation::where('resource_id', $resource->id)
        ->where('user_id', Auth::id())
        ->latest()
        ->first();

    if (!$reservation) {
        return response()->json(['message' => 'Reservation not found or unauthorized.'], 403);
    }

    // Delete the reservation or mark it as released
    $reservation->delete();

    // Mark resource as available again
    $resource->is_available = true;
    $resource->save();

    return back()->with('success', 'Resource released successfully.');
}


}

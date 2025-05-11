<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ReservationController extends Controller
{   
    public function index(){
        $reservations = Reservation::where('user_id', Auth::id())->get();
        return inertia('MyReservations', [
            'reservations' => $reservations,
        ]);
    }

    public function store(Request $request){

        $validated= $request->validate([
            'resource_id'=>'required|exists:resources,id',
            'start_date'=>'nullable|date',
            'end_date'=>'nullable|date',
        ]);

        Reservation::create([
            'user_id'=>Auth::id(),
            'resource_id'=>$validated['resource_id'],
            'start_date'=>$validated['start_date'],
            'end_date'=>$validated['end_date'],
            'status' => 'pending', // Default status

        ]);

        return redirect()->route('resource')->with('success', 'Reservation done Successfully');


    }
}

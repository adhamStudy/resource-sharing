<?php

namespace App\Http\Controllers;


;
use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
   public function index(){
    // dd(Auth::user());
    return inertia('Home');
   }


public function resource()
{


    // $resources = [
    //     [
    //         'id' => 1,
    //         'user_id' => 1,
    //         'title' => 'Lawn Mower',
    //         'description' => 'Electric lawn mower in good condition.',
    //         'image' => 'lawnmower.jpg',
    //         'is_available' => true,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ],
    //     [
    //         'id' => 2,
    //         'user_id' => 2,
    //         'title' => 'Projector',
    //         'description' => 'HD projector, great for movie nights.',
    //         'image' => 'projector.jpg',
    //         'is_available' => false,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ],
    //     [
    //         'id' => 3,
    //         'user_id' => 3,
    //         'title' => 'Ladder',
    //         'description' => '10-foot aluminum ladder.',
    //         'image' => 'ladder.jpg',
    //         'is_available' => true,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ],
    // ];

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
    $validated = $request->validate([
        'title'       => 'string|required',
        'description' => 'string|required',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images', $imageName, 'public');
        $validated['image'] = 'storage/' . $path;
    }

    Resource::create($validated);

    return redirect()->route('resource')->with('success', 'Listing was Created');
}



}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
}
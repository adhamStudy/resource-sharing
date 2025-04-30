<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return Inertia::render('Posts/Index', [
            'posts' => $posts
        ]);
    }
    
    public function create()
    {
        return Inertia::render('Posts/Create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->is_published = true;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }
        
        $post->save();
        
        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
    }
    
 
    
    

}
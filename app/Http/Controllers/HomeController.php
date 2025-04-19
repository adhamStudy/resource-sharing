<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(){
    return inertia('Home');
   }


public function resource()
{
    $resources = [
        [
            'id' => 1,
            'user_id' => 1,
            'title' => 'Lawn Mower',
            'description' => 'Electric lawn mower in good condition.',
            'image' => 'lawnmower.jpg',
            'is_available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 2,
            'user_id' => 2,
            'title' => 'Projector',
            'description' => 'HD projector, great for movie nights.',
            'image' => 'projector.jpg',
            'is_available' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 3,
            'user_id' => 3,
            'title' => 'Ladder',
            'description' => '10-foot aluminum ladder.',
            'image' => 'ladder.jpg',
            'is_available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    return inertia('Resources', [
        'resources' => $resources
    ]);
}

}
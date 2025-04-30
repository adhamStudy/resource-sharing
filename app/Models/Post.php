<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'is_published'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // // Optional: Add a comments relationship if you plan to add comments later
    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }
}

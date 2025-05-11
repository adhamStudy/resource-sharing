<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'title',
        'description',
        'image',
        'user_id'
       
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function currentReservation()
    {
        return $this->reservations()->latest()->first();
    }
}

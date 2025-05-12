<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'owner_id',
        'resource_id',
        'start_date',
        'end_date',
        'status',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}

public function resource()
{
    return $this->belongsTo(Resource::class);
}

public function owner()
{
    return $this->belongsTo(User::class, 'owner_id');
}

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{


    protected $fillable = ['title', 'name', 'description', 'image', 'lat', 'lon'];
    public function user()
    {
        return $this->belongsto(User::class);
        //Each events belongs to users
    }
}

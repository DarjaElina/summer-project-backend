<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image_url', 'lat', 'lon', 'type', 'date', 'location', 'is_public'];
    protected $casts = [
        'is_public' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
        //Each events belongs to users
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ContactForm extends Model
{
    use HasFactory;

    protected $table = 'contact_form';

    protected $fillable = [
        'name',
        'email',
        'message'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            Log::info('Creating contact form entry:', $model->toArray());
        });
    }
}

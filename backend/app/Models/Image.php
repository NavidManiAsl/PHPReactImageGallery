<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * Get the image tags.
     */
    protected function tags():Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? json_decode($value):[],
            set: fn ($value) => is_string($value) ? $value : json_encode($value)); 
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gallery()
    {
        return $this->belongsToMany(Gallery::class);
    }
}

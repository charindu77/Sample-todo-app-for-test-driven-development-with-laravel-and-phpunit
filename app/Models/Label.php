<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Label extends Model
{
    use HasFactory;

    protected $fillable=['title','color','user_id'];

    protected function title():Attribute
    {
        return Attribute::make(
                set: fn ($value) => ucwords($value),
                get: fn($value) => ucwords($value),
        );
    }
    protected function color():Attribute
    {
        return Attribute::make(
                set: fn ($value) => ucwords($value),
                get: fn ($value) => ucwords($value),
        );
    }
    
}

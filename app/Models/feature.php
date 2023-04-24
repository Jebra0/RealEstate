<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'air_condition',
        'central_heating',
        'furniture',
    ];

    protected $casts = [
        'furniture' => 'array',
    ];
}

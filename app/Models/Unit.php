<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'price',
        'type',
        'for_what',
        'date_of_posting',
        'is_available',
    ];

    protected $casts = [
        'components' => 'array',
    ];

    /////////////////////////////////////////////////
}

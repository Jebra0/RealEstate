<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'parent_unit_id',
        'price',
        'type',
        'for_what',
        'date_of_posting',
        'is_available',
        'posted_by',
    ];

    protected $casts = [
        'components' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function parent()
    {
        return $this->belongsTo(ParentUnit::class, 'parent_unit_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'unit_id');
    }

    public function feature()
    {
        return $this->hasOne(feature::class, 'unit_id', 'id');
    }

    public function reports(){
        return $this->hasMany(Report::class, 'unit_id');
    }

    /////////////////////////////////////////////////
}

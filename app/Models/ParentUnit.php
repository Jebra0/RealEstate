<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_floor' ,
        'num_of_units' ,
        'parent_name' ,
        'has_elevator' ,
        'street_name' ,
        'city_name' ,
        'state_name' ,
    ];

    public function units()
    {
        return $this->hasMany(Unit::class, 'parent_unit_id', 'id');
    }
}

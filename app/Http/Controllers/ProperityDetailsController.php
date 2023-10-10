<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class ProperityDetailsController extends Controller
{
    public function property_detail($id)
    {
        $title = 'Prosperity Details';

        $units = Unit::with('images', 'feature', 'user', 'parent')
                 ->orderBy('price', 'asc')
                 ->limit(5)->get();

        return view('property-detail', compact('units', 'title', 'id'));

    }
}

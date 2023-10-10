<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {

        $title = 'Home';

        $units = Unit::with('images', 'feature', 'user', 'parent')->limit(20)->get();

        return view('index', compact('units', 'title'));
    }

    public function about()
    {
        $title = 'About';
        return view('about', compact('title'));
    }

    public function agents()
    {
        $title = 'agents';
        return view('agents', compact('title'));
    }

    public function contact()
    {
        $title = 'Contact';
        return view('contact', compact('title'));
    }
}

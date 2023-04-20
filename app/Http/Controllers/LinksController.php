<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class LinksController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        // return $unit;
        return view('index', compact('units'));
    }

    public function about()
    {
        return view('about');
    }
    public function agents()
    {
        return view('agents');
    }

    public function blog()
    {
        return view('blog');
    }
    public function contact()
    {
        return view('contact');
    }
    public function buysalerent(Request $request)
    {
        $units = Unit::orderBy('price', 'asc')->limit(5)->get();
        $AllUnits = Unit::all();
        $Result = Unit::paginate(15);
        $by = 'asc';
        return view('buysalerent', compact(
            'units',
            'AllUnits',
            'Result',
            'by'
        ));
    }
    public function search(Request $request)
    {
//#############################################################################################
// #########################   :(  ملعون ابو السيرش علي الي عاوزه     ##############################
//##########################       :) تعديل : خلاص السيرش حلو           ###########################
//################################################################################################

        $units = Unit::orderBy('price', 'asc')->limit(5)->get();
        $AllUnits = Unit::all();
        $by = 'asc';

        $for = $request->input('for');
        $price = $request->input('price');
        $type = $request->input('type');
        $address = $request->input('address');

        $Result = Unit::where('for_what', $for)
            ->orwhere('price', '<=', $price)
            ->orwhere('type', $type)
            ->orwhere('address', 'like', '%' . $address . '%')
            ->paginate(15);
        
            return view('buysalerent', compact(
                'units',
                'AllUnits',
                'Result',
                'by',
            ));
    }

    public function sortData(Request $request)
    {
        $by = $request->input('sort', 'asc');
        $units = Unit::orderBy('price', 'asc')->limit(5)->get();
        $AllUnits = Unit::all();
        $Result = Unit::orderBy('price', $by)->paginate(15);
        return view('buysalerent', compact('Result', 'units', 'AllUnits', 'by'));
    }

    public function blogdetail()
    {
        return view('blogdetail');
    }
    public function property_detail()
    {
        $units = Unit::orderBy('price', 'asc')->limit(5)->get();
        return view('property-detail', compact('units'));
    }
}

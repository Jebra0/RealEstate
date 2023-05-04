<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class BuySaleController extends Controller
{
    public function buysalerent()
    {

        $title = 'Buy Or Rent';
        $units =  Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', 'asc')->limit(5)->get();
        $AllUnits = Unit::count();
        $Result = Unit::with('images', 'feature', 'user', 'parent')->paginate(15);
        $by = 'asc';
        return view('buysalerent', compact(
            'units',
            'AllUnits',
            'Result',
            'by',
            'title',
        ));
    }
    public function search(Request $request)
    {
//#############################################################################################
// #########################   :(  ملعون ابو السيرش علي الي عاوزه     ##############################
//##########################       :) تعديل : خلاص السيرش حلو           ###########################
//##########################       تعديل :  ملعون ابو السيرش            ###########################
//################################################################################################

        $units =  Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', 'asc')->limit(5)->get();
        $AllUnits = Unit::count();
        $by = 'asc';

        $for = $request->input('for');
        $price = $request->input('price');
        $type = $request->input('type');
        $state = $request->input('state');
        $city = $request->input('city');
        $name = $request->input('name');

        $Result = Unit::with('images', 'feature', 'user', 'parent')->where('for_what', $for)
            ->where('price', '<=', $price)
            ->orwhere('type', $type)
            ->orWhereHas('parent', function ($query) use ($state, $city, $name) {
                $query->where('state_name', 'like', '%' . $state . '%')
                    ->where('city_name', 'like', '%' . $city . '%')
                    ->where('parent_name', 'like', '%' . $name . '%');
            })
            ->paginate(15);

        $title = 'Buy Or Rent ';

        return view('buysalerent', compact(
            'units',
            'AllUnits',
            'Result',
            'by',
            'title',
        ));
    }
    public function sortData(Request $request)
    {
        $title = 'Buy Or Rent';
        $by = $request->input('sort', 'asc');
        $units = Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', 'asc')->limit(5)->get();
        $AllUnits = Unit::count();
        $Result = Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', $by)->paginate(15);
        return view('buysalerent', compact('Result', 'units', 'AllUnits', 'by', 'title'));
    }
}

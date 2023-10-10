<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Unit;
use Illuminate\Http\Request;

class AllUnitsController extends Controller
{
    public function units()
    {

        $by = 'asc';
        $title = 'Units';
        $AllUnits = Unit::count();

        $units =  Unit::with('images', 'feature', 'user', 'parent')
                  ->orderBy('price', 'asc')
                  ->limit(5)->get();

        $Result = Unit::with('images', 'feature', 'user', 'parent')->paginate(15);

        return view('units', compact(
            'units',
            'AllUnits',
            'Result',
            'by',
            'title',
        ));
    }

    public function search(Request $request)
    {

        $AllUnits = Unit::count();
        $by = 'asc';

        $units =  Unit::with('images', 'feature', 'user', 'parent')
            ->orderBy('price', 'asc')
            ->limit(5)
            ->get();

        $for = $request->input('for');
        $price = $request->input('price');
        $type = $request->input('type');
        $state = $request->input('state');
        $city = $request->input('city');
        $name = $request->input('name');

        $Result = Unit::with('images', 'feature', 'user', 'parent')
            ->where('for_what', $for)
            ->where('price', '<=', $price)
            ->orwhere('type', $type)
            ->orWhereHas('parent', function ($query) use ($state, $city, $name) {
                $query->where('state_name', 'like', '%' . $state . '%')
                    ->where('city_name', 'like', '%' . $city . '%')
                    ->where('parent_name', 'like', '%' . $name . '%');
            })
            ->paginate(15);

        $title = 'Search';

        return view('units', compact(
            'units',
            'AllUnits',
            'Result',
            'by',
            'title',
        ));
    }

    public function sort(Request $request)
    {
        $title = 'Units';
        $by = $request->input('sort', 'asc');
        $units = Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', 'asc')->limit(5)->get();
        $AllUnits = Unit::count();
        $Result = Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', $by)->paginate(15);
        return view('units', compact('Result', 'units', 'AllUnits', 'by', 'title'));
    }
}

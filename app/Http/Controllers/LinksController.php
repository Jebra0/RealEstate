<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Traits\UbloadImagesTrait;
use Database\Factories\FeatureFactory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class LinksController extends Controller
{
    use UbloadImagesTrait;

    public function index()
    {
        $units = Unit::all();
        $title = 'Home';
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
    public function salerent()
    {


//        //to insert u have 2 way : first using new keyword
//        $furniture = new FeatureFactory;
//        $furniture->air_condition = $request->has('air_condition');
//        $furniture->central_heating = $request->has('central_heating');
//        //$furniture->furniture = $request->furniture;
//        $furniture->save();
//
//        $unit = new Unit;
//        $unit->description = $request->description;
//        $unit->price = $request->price;
//        $unit->type = $request->type;
//        $unit->for_what = $request->for;
//        $unit->image = $request->image;
//        $unit->imag = [
//            $request->components1,
//            $request->components2,
//            $request->components3,
//            $request->components4,
//        ];
//        $unit->feature_id = $furniture->id;
//        $unit->save();

//        if ($request->hasFile('photo')) {
//            $image = $request->file('photo')->getClientOriginalName();
//            $path = $request->file('photo')->storeAs('Units', $image, 'AllImages');
//        }


        $title = 'Sale Or Rent';
        return view('salerent', compact('title'));
    }

    public function ubload(Request $request){
        $this->UbloadImage($request, 'Units');

        return redirect('/salerent');
    }

    public function contact()
    {
        $title = 'Contact';
        return view('contact', compact('title'));
    }
    public function buysalerent(Request $request)
    {
        $title = 'Buy Or Rent';
        $units = Unit::orderBy('price', 'asc')->limit(5)->get();
        $AllUnits = Unit::all();
        $Result = Unit::paginate(15);
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
        $title = 'Prosperity Details';
        $units = Unit::orderBy('price', 'asc')->limit(5)->get();
        return view('property-detail', compact('units', compact('title')));
    }

}

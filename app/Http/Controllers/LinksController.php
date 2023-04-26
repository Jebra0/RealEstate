<?php

namespace App\Http\Controllers;

use App\Models\feature;
use App\Models\ParentUnit;
use App\Models\Unit;
use App\Traits\UbloadImagesTrait;
use Database\Factories\FeatureFactory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use function Symfony\Component\String\u;

class LinksController extends Controller
{
    use UbloadImagesTrait;

    public function index()
    {
        // get all images and the feature of it , user , parent
        $units = Unit::with('images', 'feature', 'user', 'parent')->limit(20)->get();
        //return $units;
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
    public function blogdetail()
    {
        return view('blogdetail');
    }
    public function property_detail()
    {
        $title = 'Prosperity Details';
        $units = Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', 'asc')->limit(5)->get();
       return view('property-detail', compact('units', 'title'));
    }

}

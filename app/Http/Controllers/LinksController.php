<?php

namespace App\Http\Controllers;

use App\Models\feature;
use App\Models\Image;
use App\Models\ParentUnit;
use App\Models\Report;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\ReportUnit;
use App\Traits\UbloadImagesTrait;
use Database\Factories\FeatureFactory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\u;

class LinksController extends Controller
{
    use UbloadImagesTrait;

    public function index()
    {
        // get all images and the feature of it , user , parent
        $units = Unit::with('images', 'feature', 'user', 'parent')->limit(20)->get();
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
        $title = 'Sale Or Rent';
        return view('salerent', compact('title'));
    }

    public function ubload(Request $request){

        //features data
        $air_condition =  $request->has('air')? $request->get('air'): 0 ;
        $centrall_heating = $request->has('heat')? $request->get('heat'): 0 ;
        $bedrooms = $request->has('bedroom')? $request->get('bedroom'): null ;
        $living_rooms = $request->has('living_room')? $request->get('living_room'): null ;
        $bathroom = $request->has('bathroom')? $request->get('bathroom'): null ;
        $kitchen = $request->has('kitchen')? $request->get('kitchen'): null ;

        //parent data
        $total_floor = $request->has('floor') ? $request->get('floor'): null ;
        $num_of_units = $request->has('units') ? $request->get('units'): null ;
        $parent_name = $request->has('Property') ? $request->get('Property'): null ;
        $state_name = $request->has('state') ? $request->get('state'): null ;
        $street_name = $request->has('street') ? $request->get('street'): null ;
        $city_name = $request->has('city') ? $request->get('city'): null ;
        $hase_elevator = $request->has('elevator') ? $request->get('elevator'): 0 ;

        //unit data
        $description = $request->has('description')? $request->get('description') : null ;
        $price = $request->has('price')? $request->get('price') : null ;
        $type = $request->has('type') ? $request->get('type') : null ;
        $for_what = $request->has('for') ? $request->get('for') : null ;

        $parent_unit = new ParentUnit();
        $parent_unit->total_floor = $total_floor;
        $parent_unit->num_of_units = $num_of_units;
        $parent_unit->parent_name = $parent_name;
        $parent_unit->has_elevator = $hase_elevator;
        $parent_unit->street_name = $street_name;
        $parent_unit->city_name = $city_name;
        $parent_unit->state_name = $state_name;
        $parent_unit->save();

        $unit = new Unit();
        $unit->description = $description ;
        $unit->price = $price ;
        $unit->type = $type ;
        $unit->for_what = $for_what ;
        $unit->date_of_posting = now() ;
        $unit->is_available = 1 ;
        $unit->posted_by =  Auth::id();;
        $unit->parent_unit_id = $parent_unit->id ;
        $unit->save();

        $features = new feature();
        $features->air_condition = $air_condition;
        $features->central_heating = $centrall_heating;
        $features->bedrooms = $bedrooms;
        $features->living_rooms = $living_rooms;
        $features->bathroom = $bathroom;
        $features->kitchen = $kitchen;
        $features->unit_id = $unit->id;
        $features->save();

        //trait function i made to upload the array of images
        $url_images = $this->UbloadImage($request, 'Units');

        for($i=0; $i<count($url_images); $i++){
            $images = new Image();
            $images->unit_id = $unit->id;
            $images->imag = $url_images[$i] ;
            $images->save();
        }

        return redirect('/');
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

    public function ReportUnit(Request $request, $id){
        if($request->confirmed){
            $report = Report::create([
                'user_id' => Auth::id(),
                'unit_id' => $id,
            ]);
        }
        $unit = Unit::with('user')->where('id', $id)->first();
        $user = $unit->getRelation('user');
        $author = User::find($user->id);

        $admins = User::where('is_admin', '=', 1)->get();

        Notification::send($admins, new ReportUnit($id, $user->id, Auth::id()));
        Notification::send($author, new ReportUnit($id, $user->id, Auth::id()));
        return redirect()->back();
    }

}

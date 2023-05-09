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
use Illuminate\Support\Facades\DB;
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

    public function blogdetail()
    {
        return view('blogdetail');
    }
    public function property_detail($id)
    {
        $title = 'Prosperity Details';
        $units = Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', 'asc')->limit(5)->get();
        return view('property-detail', compact('units', 'title', 'id'));

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

    public function displayTheTargitPost($id){
        $notification = DB::table('notifications')->where('data->unit_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $notification)->update(['read_at' => now()]);

        $title = 'Report Details';
        $units = Unit::with('images', 'feature', 'user', 'parent')->where('id', $id)->get();
        return view('report-detail', compact('id', 'title', 'units'));
    }

    public function sold($id){
        DB::table('units')->where('id', $id)->update(['is_available' => 0 ]);
        return redirect()->back();
    }
    public function delet_unit($id){
        feature::where('unit_id', $id)->delete($id);
        Image::where('unit_id', $id)->delete($id);
        Unit::where('id', $id)->delete($id);

        return redirect()->route('index')->with('success', 'Unit deleted successfully.');
    }
    public function delete_image($id){
        Image::where('id', $id)->delete($id);
        return redirect('/');
    }
    public function showUnit($id){
        $unit = Unit::with('images', 'feature', 'parent')->where('id', $id)->first();
        //return $unit;
        $title = 'update unit';
        return view('update-unit', compact('unit', 'title'));
    }
    public function updateUnit(Request $request, $id){
        //features data
        if($request->get('air')  ?? 0 != $request->get('old_air') ){
            $air_condition = $request->get('air');
        }else{
            $air_condition = $request->get('old_air');
        }
        if($request->get('heat')  ?? 0 !=$request->get('old_heat') ){
            $centrall_heating = $request->get('heat');
        }else{
            $centrall_heating = $request->get('old_heat');
        }
        if($request->get('bedroom')!=$request->get('old_bedroom') ){
            $bedrooms =  $request->get('bedroom') ;
        }else{
            $bedrooms =  $request->get('old_bedroom') ;
        }
        if($request->get('living_room')!=$request->get('old_living_room') ){
            $living_rooms = $request->get('living_room');
        }else{
            $living_rooms = $request->get('old_living_room');
        }
        if($request->get('bathroom')!=$request->get('old_bathroom') ){
            $bathroom = $request->get('bathroom');
        }else{
            $bathroom = $request->get('old_bathroom');
        }
        if($request->get('kitchen')!=$request->get('old_kitchen') ){
            $kitchen = $request->get('kitchen');
        }else{
            $kitchen = $request->get('old_kitchen');
        }

        //parent data
        if($request->get('floor')!=$request->get('old_floor') ){
            $total_floor = $request->get('floor');
        }else{
            $total_floor = $request->get('old_floor');
        }
        if($request->get('units')!=$request->get('old_units') ){
            $num_of_units = $request->get('units');
        }else{
            $num_of_units = $request->get('old_units');
        }
        if($request->get('Property')!=$request->get('old_Property') ){
            $parent_name =  $request->get('Property') ;
        }else{
            $parent_name =  $request->get('old_Property') ;
        }
        if($request->get('state')!=$request->get('old_state') ){
            $state_name = $request->get('state');
        }else{
            $state_name = $request->get('old_state');
        }
        if($request->get('street')!=$request->get('old_street') ){
            $street_name = $request->get('street');
        }else{
            $street_name = $request->get('old_street');
        }
        if($request->get('city')!=$request->get('old_city') ){
            $city_name = $request->get('city');
        }else{
            $city_name = $request->get('old_city');
        }
        if($request->get('elevator')  ?? 0 !=$request->get('old_elevator') ){
            $hase_elevator = $request->get('elevator');
        }else{
            $hase_elevator = $request->get('old_elevator');
        }

        //unit data
        if($request->get('description')!=$request->get('old_description') ){
            $description = $request->get('description');
        }else{
            $description = $request->get('old_description');
        }
        if($request->get('price')!=$request->get('old_price') ){
            $price = $request->get('price');
        }else{
            $price = $request->get('old_price');
        }
        if($request->get('type')!=$request->get('old_type') ){
            $type =  $request->get('type') ;
        }else{
            $type =  $request->get('old_type') ;
        }
        if($request->get('for')!=$request->get('old_for') ){
            $for_what = $request->get('for');
        }else{
            $for_what = $request->get('old_for');
        }

        $parent_unit_id = Unit::where('id', $id)->pluck('parent_unit_id')->first();
        ParentUnit::where('id', $parent_unit_id)
            ->update([
                'total_floor' => $total_floor,
                'num_of_units' => $num_of_units,
                'parent_name' => $parent_name,
                'state_name' => $state_name,
                'street_name' => $street_name,
                'city_name' => $city_name,
                'has_elevator' => $hase_elevator,
            ]);

        Unit::where('id', $id)
            ->update([
            //unit
            'description' => $description,
            'price' => $price,
            'type' => $type,
            'for_what' => $for_what,
        ]);

        feature::where('unit_id', $id)
            ->update([
                //featuers
                'air_condition' => $air_condition,
                'bedrooms' => $bedrooms,
                'living_rooms' => $living_rooms,
                'bathroom' => $bathroom,
                'kitchen' => $kitchen,
            ]);

        $url_images = $this->UbloadImage($request, 'Units');
        if ($request->hasFile('image')) {
            for($i=0; $i<count($url_images); $i++){
                $images = new Image();
                $images->unit_id = $id;
                $images->imag = $url_images[$i] ;
                $images->save();
            }
        }

        return redirect('/');
    }

}

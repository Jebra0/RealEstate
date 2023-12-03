<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUnitRequest;
use App\Models\feature;
use App\Models\Image;
use App\Models\ParentUnit;
use App\Models\Unit;
use App\Traits\UbloadImagesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UnitController extends Controller
{
    use UbloadImagesTrait;

    /**
     * Display a listing of the resource.
     */
    public function index() // /units
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

    /**
     * Show the form for creating a new resource.
     */
    public function create() // /add-unit
    {
        $title = 'Upload Unit';
        return view('UploadUnit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddUnitRequest $request) // /units/upload
    {
        $validated = $request->validated();

        // assign data to database transaction

        $parent_unit = new ParentUnit();
        $parent_unit->total_floor = $validated['floor'];
        $parent_unit->num_of_units = $validated['units'];
        $parent_unit->parent_name = $validated['Property'];
        $parent_unit->has_elevator = $validated['elevator'];
        $parent_unit->street_name = $validated['street'];
        $parent_unit->city_name = $validated['city'];
        $parent_unit->state_name = $validated['state'];
        $parent_unit->save();

        $unit = new Unit();
        $unit->description = $validated['description'] ;
        $unit->price = $validated['price'] ;
        $unit->type = $validated['type'];
        $unit->for_what = $validated['for'];
        $unit->date_of_posting = now();
        $unit->is_available = 1 ;
        $unit->posted_by =  Auth::id();
        $unit->parent_unit_id = $parent_unit->id ;
        $unit->save();

        $features = new feature();
        $features->air_condition = $validated['air'];
        $features->central_heating = $validated['heat'];
        $features->bedrooms = $validated['bedroom'];
        $features->living_rooms = $validated['living_room'];
        $features->bathroom = $validated['bathroom'];
        $features->kitchen = $validated['kitchen'];
        $features->unit_id = $unit->id;
        $features->save();

        if ($request['image']){
            //upload the images
            $url_images = $this->UbloadImage($request, 'Units');

            for($i=0; $i<count($url_images); $i++){
                $images = new Image();
                $images->unit_id = $unit->id;
                $images->imag = $url_images[$i] ;
                $images->save();
            }
        }else{
            $images = new Image();
            $images->unit_id = $unit->id;
            $images->save();
        }


        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) // /property-details
    {
        $title = 'Prosperity Details';

        $units = Unit::with('images', 'feature', 'user', 'parent')
            ->orderBy('price', 'asc')
            ->limit(5)->get();

        return view('property-detail', compact('units', 'title', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) // /show{}
    {
        $unit = Unit::with('images', 'feature', 'parent')->where('id', $id)->first();

        $title = 'update unit';

        return view('update-unit', compact('unit', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) // /update{}
    {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) // /deleteUnit{}
    {
        //helper function in /App/helper.php
        Delete_Unit($id);

        return redirect()->route('index');
    }

// un resource methods
    /**
     * search for unit.
     * ***************
     * * form route => u can found it in home + units views
     * * search rout + redirect with the result
     */
    public function search(Request $request) // /search
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

    /**
     * delete specific image in route /show.
     */
    public function delete_unit_image($id)
    {
        Image::where('id', $id)->delete($id);
        return redirect('/');
    }

    /**
     * make the unit unavailable, in route /show.
     */
    public function mark_as_sold($id)
    {
        DB::table('units')->where('id', $id)->update(['is_available' => 0 ]);
        return redirect()->back();
    }

    /**
     * make the unit available again, in route /show.
     */
    public function mark_as_available($id)
    {
        DB::table('units')->where('id', $id)->update(['is_available' => 1 ]);
        return redirect()->back();
    }

    /**
     * sort the units DSC or ASC in route /units.
     */
    public function sort_units(Request $request)
    {
        $title = 'Units';
        $by = $request->input('sort', 'asc');
        $units = Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', 'asc')->limit(5)->get();
        $AllUnits = Unit::count();
        $Result = Unit::with('images', 'feature', 'user', 'parent')->orderBy('price', $by)->paginate(15);
        return view('units', compact('Result', 'units', 'AllUnits', 'by', 'title'));
    }

}

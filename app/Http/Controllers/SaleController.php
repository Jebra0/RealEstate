<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUnitRequest;
use App\Models\feature;
use App\Models\Image;
use App\Models\ParentUnit;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use  App\Traits\UbloadImagesTrait;


class SaleController extends Controller
{
    use UbloadImagesTrait;
    public function AdddUnit() //form
    {
        $title = 'Upload Unit';
        return view('UploadUnit', compact('title'));
    }

    public function store(AddUnitRequest $request){

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
        $unit->type = $validated['type'] ;
        $unit->for_what = $validated['for'] ;
        $unit->date_of_posting = now() ;
        $unit->is_available = 1 ;
        $unit->posted_by =  Auth::id();;
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

        //upload the images
        $url_images = $this->UbloadImage($request, 'Units');

        for($i=0; $i<count($url_images); $i++){
            $images = new Image();
            $images->unit_id = $unit->id;
            $images->imag = $url_images[$i] ;
            $images->save();
        }

       return redirect('/');
    }
}


<?php

use App\Models\Report;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

function GetUnit($id){
    return  Unit::with('images', 'feature', 'user', 'parent')->where('id', $id)->first();
}

function GetUser($id){
    return User::where('id', $id)->first();
}

function IsReported ($id){

    $UserRebortBefor = Report::where('user_id', Auth::id())
                        ->where('unit_id', $id)
                        ->get();
    if(count($UserRebortBefor)>0){
        return 1;
    }else{
        return 0;
    }


}

function Delete_Unit($id){

    DB::transaction(function() use ($id) {
        $unit = DB::table('units')->where('id', $id);
        $parent_id = $unit->pluck('parent_unit_id')[0];
        DB::table('features')->where('unit_id', $id)->delete();
        $images = DB::table('images')->where('unit_id', $id)->get();
        foreach ($images as $image)
        {
            ////// Bug | the image did not deleted from storage ///////
            //////////////////////////////////////////////////////////
            $img = substr($image->imag, 6);
            if (Storage::exists('public/images/Units/'.$img)){
                Storage::delete('public/images/Units/'.$img);
            }
            DB::table('images')->where('id', $image->id)->delete();
        }

        DB::table('units')->where('id', $id)->delete();
        DB::table('parent_units')->where('id', $parent_id)->delete();
    });

}




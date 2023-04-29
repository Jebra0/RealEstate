<?php

use App\Models\Report;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

function GetUnit($id){
    return  Unit::with('images', 'feature', 'user', 'parent')->where('id', $id)->first();
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




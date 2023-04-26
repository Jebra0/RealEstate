<?php

use App\Models\Unit;
use App\Models\User;

function GetUnit($id){
    return  Unit::with('images', 'feature', 'user', 'parent')->where('id', $id)->first();
}

function GetUserWhoPost($id){
    return  User::where('id', $id)->first();
}




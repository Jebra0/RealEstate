<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\ReportUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ReportController extends Controller
{
    public function ReportUnit(Request $request, $id){

        Report::create([
            'user_id' => Auth::id(),
            'unit_id' => $id,
        ]);

        $unit = Unit::with('user')->where('id', $id)->first();

        $user = $unit->getRelation('user');

        $author = User::find($user->id);

        Notification::send($author, new ReportUnit($id, $user->id, Auth::id()));

        return redirect()->back();
    }
}

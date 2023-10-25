<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\ReportUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ReportController extends Controller
{
    public function report($id)
    {
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

    public function show($id) // show the reported unit
    {
        $notification = DB::table('notifications')->where('data->unit_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $notification)->update(['read_at' => now()]);

        $title = 'Report Details';
        $units = Unit::with('images', 'feature', 'user', 'parent')->where('id', $id)->get();
        return view('report-detail', compact('id', 'title', 'units'));
    }

}

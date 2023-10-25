<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UnitController;
use App\Models\Unit;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {

    $title = 'Home';
    $units = Unit::with('images', 'feature', 'user', 'parent')->limit(20)->get();
    return view('index', compact('units', 'title'));

})->name('index');

Route::get('/about', function(){

    $title = 'About';
    return view('about', compact('title'));

})->name('about');

Route::get('/agents', function(){

    $title = 'agents';
    return view('agents', compact('title'));

})->name('agents');

Route::get('/contact', function(){
    $title = 'Contact';
    return view('contact', compact('title'));
})->name('contact');

Route::resource('Units', UnitController::class);

Route::controller(UnitController::class)->group(function (){

    Route::post('/units-search', 'search')->name('units.search');
    Route::get('/delete-image/{id}', 'delete_unit_image')->name('delete.image'); // transform it to post + route model binding
    Route::get('/mark-sold/{id}', 'mark_as_sold')->name('mark.sold'); // transform it to post + route model binding
    Route::get('/mark-available/{id}', 'mark_as_available')->name('mark.available');
    Route::get('/sort-units', 'sort_units')->name('sort.units'); // it is get ok

});

Route::controller(ReportController::class)->group(function (){
    Route::POST('/report/{id}', 'report')->name('report'); // rout model binding
    Route::GET('/report/{id}', 'show')->name('reported-unit'); // rout model binding
});

require __DIR__.'/auth.php';




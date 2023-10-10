<?php

use App\Http\Controllers\LinksController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//start the re routing
//Home
Route::controller(\App\Http\Controllers\IndexController::class)->group(function (){
    Route::get('/', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/agents', 'agents')->name('agents');
    Route::get('/contact', 'contact')->name('contact');

});

//Property details
Route::controller(\App\Http\Controllers\ProperityDetailsController::class)->group(function (){
    Route::get('/property_detail{id}', 'property_detail')->name('propertydetail');
});

//All Units and Search
//###### when i touch the search form it redirect me to blog details why?????????
Route::controller(\App\Http\Controllers\AllUnitsController::class)->group(function (){
    Route::get('/units', 'units')->name('units');
    Route::get('/units/search', 'search')->name('search');
    Route::get('/units/sorted', 'sort')->name('sortData');
});


//end the re routing

Route::controller(LinksController::class)->group(function() {
    Route::any('/salerent', 'salerent')->name('salerent');
    Route::any('/salerent/ubload', 'ubload')->name('ubload');
    Route::any('/report{id}', 'ReportUnit')->name('report');
    Route::any('/notifications{id}', 'displayTheTargitPost')->name('notification');
    Route::any('/sold{id}', 'sold')->name('sold');
    Route::any('/available{id}', 'available')->name('available');
    Route::any('/deletUnit{id}', 'delet_unit')->name('delet_unit');
    Route::any('/update{id}', 'updateUnit')->name('ubdate');
    Route::any('/show{id}', 'showUnit')->name('show');
    Route::any('/deleteImage{id}', 'delete_image')->name('delete_image');

});

require __DIR__.'/auth.php';




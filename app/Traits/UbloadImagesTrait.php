<?php

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isFalse;

trait UbloadImagesTrait
{
    public function UbloadImage(Request $request, $folderName){
        $validator = $request->validate([
            'image.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        $images = $request->file('image');
        if ($request->hasFile('image')) {
            foreach ($images as $image) {
                $name = $image->getClientOriginalName();
                $path[] = $image->storeAs($folderName, 'UNIT' . $name, 'AllImages');
            }
            return $path;
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}

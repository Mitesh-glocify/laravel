<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageCropperController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUpload() {
        return view('exclusive/image-cropper/index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUploadPost(Request $request) {
        $validator = Validator::make($request->all(), [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        $request->session()->flash('success', $imageName);
        $request->image->move(public_path('tmp'), $imageName);

        return view('exclusive/image-cropper/index');
    }

}

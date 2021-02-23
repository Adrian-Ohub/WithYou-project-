<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Photo;
use Image;

class PhotoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    function upload(Request $request)
    {
     $image = $request->file('file');

     foreach($image as $img){

        $fileName = $img->getClientOriginalName();


        $img->storeAs(Auth::user()->id, $fileName, 'public');

        $photo = new Photo;
        $photo->user_id = Auth::User()->id;
        $photo->src = $fileName;
        $photo->save();

        $destinationPath_res =  public_path('storage'.'/'.Auth::user()->id.'/rescaling');
        
        if(!file_exists($destinationPath_res)){
            File::makeDirectory(public_path('storage'.'/'.Auth::user()->id.'/rescaling'));
        }

        $img_res = Image::make($img->path());
        $img_res->fit(600, 600, function ($constraint) {
            $constraint->upsize();
        })->save($destinationPath_res.'/'. $fileName);

     }

     return response()->json(['success']);
    }

    function fetch()
    {
     $images = File::Files(public_path('storage/'.Auth::user()->id));
     $output = '<div class="row">';
     foreach($images as $image)
     {   
      $output .= '
      <div class="col-md-2" style="margin-bottom:16px;" align="center">
                <img src="'.asset('storage'.'/'.Auth::user()->id.'/rescaling/'. $image->getFilename()).'" class="img-thumbnail" />
                <button type="button" class="btn btn-link remove_image" id="'.$image->getFilename().'">Remove</button>
      </div>';
     }
     $output .= '</div>';
     echo $output;
    }

    function delete(Request $request)
    {
     if($request->get('name'))
     {
      File::delete(public_path('storage'.'/'.Auth::user()->id).'/'. $request->get('name'));
      File::delete(public_path('storage'.'/'.Auth::user()->id).'/rescaling/'. $request->get('name'));
      Photo::where('src', $request->get('name'))->delete();
     }
    }
}



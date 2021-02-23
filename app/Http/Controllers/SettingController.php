<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Setting;
use App\Location;


class SettingController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function update(Request $request)
    {
        $user = Auth::user()->id;
           
        $settings = Setting::where('user_id', $user)->first();
        $myLoc = Location::where('user_id', $user)->first();
        $comprobar_loc = Location::where('place_id', $request->place_id)->get();
        if($comprobar_loc->count() < 1){  
            return redirect()->back()->with('alert','No se han encontrado usuarios, cambia las preferencias');
        }
        
        $settings->place_id = $request->place_id;
        $settings->address = $request->formatted_address;
        $settings->lat = $request->lat;
        $settings->lng = $request->lng;
        $settings->rango_edad_min = $request->rango_edad_min;
        $settings->rango_edad_max = $request->rango_edad_max;
        $settings->muestrame = $request->muestrame;
        $settings->save();

        $myLoc->place_id = $request->place_id;
        $myLoc->address = $request->formatted_address;
        $myLoc->lat = $request->lat;
        $myLoc->lng = $request->lng;
        $myLoc->save();


        return redirect()->back()->with('status','Se han cambiado las preferencias');
        
    }   
}

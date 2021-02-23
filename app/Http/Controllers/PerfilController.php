<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Photo;
use Image;

class PerfilController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Request::is('perfil/'.Auth::id().'/edit')) { 
                      
            $user = User::find($id);
            
            return view('perfil', compact('user'));
            
        }else{
                return redirect('/perfil/'.Auth::id().'/edit');
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        //dd($request);
        if(Auth::user()->email == $request->email) {

            $this->validate($request, [
                'descripcion' => ['max:500'],
            ]);
            $user_update = User::find($id);
            //$user_update->password = Hash::make($request->password);
            $user_update->descripcion = $request->descripcion;
            if($request->hasfile('imagen')){
                File::delete(public_path('storage'.'/'.Auth::user()->id).'/avatar/'. $request->avatarActual);
                File::delete(public_path('storage'.'/'.Auth::user()->id).'/_avatar/'. $request->avatarActual);
                $imagen = $request->file('imagen');
                $fileName = $imagen->getClientOriginalName();
                $path_imagen = $request->file('imagen')->storeAs(Auth::user()->id.'/avatar', $fileName, 'public');
                $user_update->imagen = $fileName;

                $destinationPath_res =  public_path('storage'.'/'.Auth::user()->id.'/_avatar');

                $img_res = Image::make($imagen->path());
                $img_res->fit(600, 600, function ($constraint) {
                $constraint->upsize();
                })->save($destinationPath_res.'/'. $fileName);
            }
            
            $user_update->save();

            }else{
                
                $this->validate($request, [
                    'email' => ['string', 'email', 'max:255', 'unique:users'],
                    'descripcion' => ['max:500'],
                ]); 
                $user_update = User::find($id);
                $user_update->email = $request->email;
                $user_update->email_verified_at = null;
                //$user_update->password = Hash::make($request->password);
                $user_update->descripcion = $request->descripcion;
                if($request->hasfile('imagen')){
                    File::delete(public_path('storage'.'/'.Auth::user()->id).'/avatar/'. $request->avatarActual);
                    File::delete(public_path('storage'.'/'.Auth::user()->id).'/_avatar/'. $request->avatarActual);
                    $imagen = $request->file('imagen');
                    $fileName = $imagen->getClientOriginalName();
                    $path_imagen = $request->file('imagen')->storeAs(Auth::user()->id.'/avatar', $fileName, 'public');
                    $user_update->imagen = $fileName;

                    $destinationPath_res =  public_path('storage'.'/'.Auth::user()->id.'/_avatar');

                    $img_res = Image::make($imagen->path());
                    $img_res->fit(600, 600, function ($constraint) {
                    $constraint->upsize();
                    })->save($destinationPath_res.'/'. $fileName);
                }

                $user_update->save();

            }
            

        return redirect()->back()->with('success', 'Se ha actualizado tu perfil');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        File::delete(public_path('storage'.'/'.Auth::user()->id));
        
        User::find($request->user_id)->delete();
        
        Auth::logout();
        Session::flush();
        return redirect('/');
        
        
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Setting;
use App\Location;
use Carbon\Carbon;
use Image;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
        return Validator::make($data, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido1' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'date', 'max:255'],
            'sexo' => 'required|in:hombre,mujer,inter',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'descripcion' => ['max:500'],
            'imagen' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $request = app('request');
        if($request->hasfile('imagen')){
            $imagen = $request->file('imagen');
            $fileName = $imagen->getClientOriginalName();
        }

        //Creacion de usuario
        $newUser = User::create([
            'nombre' => $data['nombre'],
            'apellido1' => $data['apellido1'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'sexo' => $data['sexo'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'imagen' => $fileName,
            'descripcion' => $data['descripcion'],
        ]);
        
        //Añado la imagen al usuario nuevo
        $path_imagen = $request->file('imagen')->storeAs($newUser->id.'/avatar', $fileName, 'public');
        
        $destinationPath_res = public_path('storage'.'/'.$newUser->id.'/_avatar');
        
        if(!file_exists($destinationPath_res)){
            File::makeDirectory(public_path('storage'.'/'.$newUser->id.'/_avatar'));
        }

        $img_res = Image::make($imagen->path());
            $img_res->fit(600, 600, function ($constraint) {
            $constraint->upsize();
            })->save($destinationPath_res.'/'. $fileName);

        //Creacion de localizacion
        $newLocation = Location::Create([
            'user_id' => $newUser->id,
            'place_id' => $data['place_id'],
            'address' => $data['formatted_address'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
        ]);

        //Cambiarlo o incluirlo en el formulario
        /* $user_id = $newUser->id;
        if($data['sexo'] == 'hombre'){
            $mostrar = 'mujer';
        }else{
            $mostrar = 'hombre';
        } */

        //Creacion default settings en la creacion del usuario, unicamente recojo la posicion, los demas parametros los creo en la base de datos
        $newSettings = Setting::create([
            'user_id' => $newUser->id,
            'place_id' => $data['place_id'],
            'address' => $data['formatted_address'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
        ]);
        
        return $newUser;

    }
}

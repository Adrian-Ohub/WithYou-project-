<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Notifications\HasMatched;
use App\User;
use App\Photo;
use App\Setting;
use App\Location;
use App\Like;
use Carbon\Carbon;

class HomeController extends Controller
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

    public function index(User $the_users)
    {
        // Hacer consulta previa a "settings" para generar el array usuarios
        $user = Auth::user();
        
        // Filtro settings (localizacion, rango edad y sexo)
        $settings_user = $user->setting;
        
        $the_users = $the_users->newQuery();
        
        $rest_users = $this->GetRestUsers($settings_user, $the_users);

        if(sizeof($rest_users) > 0) {
            $user_random = ($rest_users->random());
            
            $photos_user_random = $user_random->photos;
            
            $list_matches = $this->GetMatchUsers();
    
            return view('home', compact('user_random','photos_user_random', 'user', 'list_matches'));
            
        }else{

            return view('changesettings', compact('user'))->with('alert','No se han encontrado usuarios, cambia las preferencias');

        }
    }

    public function like(Request $request, User $the_users)
    {
        
        $check_like = Like::where([['user_id2', Auth::user()->id],['user_id', $request->user_id2]])->first();

        // Comprobación del check like o visualización por parte del otro usuario
        if(is_null($check_like)){
            
            //Registro like
            $like = new Like;
            $like->user_id = Auth::user()->id;
            $like->user_id2 = $request->user_id2;
            $like->save();

        /* //Añadiendo esta linea seria para verificar los dislikes, de momento esta hecho para repetirlos   
        }elseif (Like::where('user_id2', Auth::id()) && Like::where('user_id', $request->user_id2) && Like::where('return_like', false)){
         */

        }else{
            // Comprobación del check like y generación de Match
            $check_like = Like::where('user_id2', Auth::user()->id)->orwhere('user_id', $request->user_id2);
            $check_like->update(['return_like' => true]);
            
            // Evento para notificación del Match
            $read_at = Carbon::now()->toDateTimeString(); 
            Auth::user()->notify(new HasMatched(User::find($request->user_id2), $read_at));
            User::find($request->user_id2)->notify(new HasMatched(Auth::user(), $read_at));

        }

        $user = Auth::user();
        
        $settings_user = $user->setting;
        
        $the_users = $the_users->newQuery();
        
        $rest_users = $this->GetRestUsers($settings_user, $the_users);
        
        if(sizeof($rest_users) > 0) {

            $user_random = ($rest_users->random());

            // Generación de ususarios aleatorios de acuerdo a "settings"
            $photos_user_random = $user_random->photos;

            $list_matches = $this->GetMatchUsers();

            return View::make('partials/photo-gallery', compact('user_random','photos_user_random', 'user', 'list_matches'));
            
        }else{

            return View::make('partials/changesettings', compact('user'))->with('alert','No se han encontrado usuarios, cambia las preferencias');

        }
    }

    public function dislike(Request $request, User $the_users)
    {
        $user = Auth::user();
        
        $settings_user = $user->setting;
        
        $the_users = $the_users->newQuery();
        
        $rest_users = $this->GetRestUsers($settings_user, $the_users);
        
        $user_random = ($rest_users->random());
        
        $photos_user_random = $user_random->photos;

        $list_matches = $this->GetMatchUsers();

        return View::make('partials/photo-gallery', compact('user_random','photos_user_random', 'user', 'list_matches'));

    }
    
    private function GetRestUsers($settings_user, $the_users)
    {
        if($settings_user->muestrame != 'todo'){
            $the_users = User::select()
            ->where('sexo', '=', $settings_user->muestrame)
            ->whereRaw('timestampdiff(year, fecha_nacimiento, curdate()) between ? and ?', [$settings_user->rango_edad_min, $settings_user->rango_edad_max])
            ->join('locations', 'locations.user_id', '=', 'users.id')
            ->where('locations.place_id', $settings_user->place_id)
            ->get('id');
 
        }else{
            $the_users = User::select()
            ->whereRaw('timestampdiff(year, fecha_nacimiento, curdate()) between ? and ?', [$settings_user->rango_edad_min, $settings_user->rango_edad_max])
            ->join('locations', 'locations.user_id', '=', 'users.id')
            ->where('locations.place_id', $settings_user->place_id)
            ->get('id');

        }
        
        $the_users = $the_users->except(Auth::id());
        
        $array_ids_I_liked_and_matched = [];

        $users_i_liked = Like::where('user_id', Auth::user()->id)->get('user_id2');
        $users_i_matched = Like::where([['user_id2', Auth::user()->id],['return_like', true]])->get('user_id');
        
        foreach($users_i_liked as $user_liked) {
            array_push($array_ids_I_liked_and_matched, $user_liked['user_id2']);
        }
        foreach($users_i_matched as $user_liked) {
            array_push($array_ids_I_liked_and_matched, $user_liked['user_id']);
        }
        
       // LISTA DE USUARIOS QUE NO HE DADO LIKE NI MATCHEADO 

        if($array_ids_I_liked_and_matched === []){
            
            $rest_users = $the_users;
        }else{
            $arrayIds_the_users = [];
            for($i = 0; $i<count($the_users) ; $i++) {
                array_push($arrayIds_the_users, $the_users[$i]['id']);
            }
            $idsRest_users = array_diff($arrayIds_the_users, $array_ids_I_liked_and_matched);
            $rest_users = User::find($idsRest_users);  
        }
        return($rest_users);
    }

    private function GetMatchUsers()
    {
        $array_list_matches = [];
        $users_mached_me = Like::where([['user_id', Auth::user()->id],['return_like', true]])->get('user_id2');
        $users_i_matched = Like::where([['user_id2', Auth::user()->id],['return_like', true]])->get('user_id');

        foreach($users_mached_me as $match) {
            array_push($array_list_matches, $match['user_id2']);
        }
        foreach($users_i_matched as $match) {
            array_push($array_list_matches, $match['user_id']);
        }
        $users_list_matches = User::find($array_list_matches);
        return($users_list_matches);
    }
}
<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\LivechatEvent;
use App\User;
use App\Like;
use App\Livechat;
use App\Photo;

class LiveChatController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'user_id2' => 'required',
            'canal' => 'required',
            'mensaje' => 'required',
        ]);

        $mensaje = new Livechat;

        $mensaje->user_id = $request->user_id;
        $mensaje->user_id2 = $request->user_id2;
        $mensaje->mensaje = $request->mensaje;
        $mensaje->save();

        $user = Auth::user();

        $canal = $request->canal;

        event(new LivechatEvent($mensaje, $user, $canal));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list_ids_matches = $this->GetMatchUsersIds(); 
        
        if(in_array($id, $list_ids_matches)) {
            $user_id = Auth::user();
            $user_id2 = User::find($id);
            $mensajes = Livechat::all();
            $photos_user_id2 = $user_id2->photos;
            if($user_id->id < $user_id2->id){
                $canal = $user_id->id . $user_id2->id;
            }else{
                $canal = $user_id2->id . $user_id->id;
            }

            return view('livechat', compact('user_id', 'user_id2', 'mensajes', 'canal', 'photos_user_id2'));
        
        }else{
            return redirect()->back();  
        }
       
    }
    private function GetMatchUsersIds()
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
        
        return($array_list_matches);
    }
}

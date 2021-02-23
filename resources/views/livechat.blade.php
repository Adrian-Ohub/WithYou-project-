@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('css/livechat/livechatstyle.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{$user_id2->nombre}} - {{$user_id2->age}} años</div>
                <div class="card-body">
                    <div class="card-text">
                        <p class="">{{$user_id2->descripcion}}</p>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header ">
                    LiveChat <span style="color: #cc6699">&nbsp;WITH YOU</span>
                    {{-- <img class="img-media rounded-circle float-right" src="{{ asset('storage/'.$user_id2->id.'/avatar/'.$user_id2->imagen) }}" alt="{{$user_id2->imagen}}" style="width: 50px; height: 50px;"> --}}
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="panel-body">
                
                        <div id="mensajes" style="height: 450px; max-height: 425px; overflow-y: auto; padding:20px;">
                        
                            @forelse ($mensajes as $mensaje)
                                 {{-- si el mensaje sale del user logeado(mio) y el id 'para' es de receptor --}} 
                                @if($mensaje->user_id == $user_id->id && $mensaje->user_id2 == $user_id2->id)
                                <div  class="emisor">
                                    <p>Digo: {{ $mensaje->mensaje }}</p>  
                                </div>
                                @endif
                                 {{-- si el mensaje sale del receptor y el id 'para' es del user logeado(mio) --}} 
                                @if ($mensaje->user_id == $user_id2->id && $mensaje->user_id2 == $user_id->id)
                                <div class="receptor">
                                    <p>{{ $user_id2->nombre }} dice: {{ $mensaje->mensaje }}</p>   
                                </div>
                                @endif
                                @empty
                                <div id="mensaje-inicio">
                                    No sabes como romper el hielo? Presentate y pregunta!
                                    <br>
                                    Aqui tienes su descripcion por si te ayuda:
                                    <br>
                                    {{$user_id2->descripcion}}
                                </div>
                            @endforelse
                            <span id="mensaje_enviado"></span>
                        </div>     
                            
                            <br>

                             {{-- FROMULARIO DE MENSAJE  --}}

                            
                            <form id="mensaje_form" method="post" action="{{route('livechat.store')}}">
                                @csrf    
                                <div class="input-group">
                                    
                                    <input type="hidden" name="user_id" id="user_id" class="from-control" value="{{ $user_id->id }}">  
                                    <input type="hidden" name="user_id2" id="user_id2" class="from-control" value="{{ $user_id2->id }}"> 
                                    <input type="hidden" name="canal" id="canal" class="from-control" value="{{ $canal }}" hidden> 
                                    <input type="text" name="mensaje" id="mensaje" class="from-control" placeholder="Escribe aqui...">
                                    <div class="input-group-append">
                                        <button type="submit" id="enviar">Enviar</button>   
                                    </div>              
                                </div> 
                            </form>
                            <span class="typing" style="display:none; color: rgb(191, 191, 191); font-style: italic; margin-left: 20px;">{{$user_id2->nombre}} esta escribiendo...</span>
                        
                    </div>           
                </div>
            </div>
        </div>
        {{-- Galleria de fotos del user_id2 --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">Galeria de fotos</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="slider-content">
                                @forelse ($photos_user_id2 as $imagen)
                                <div class="slider-item"><a
                                        href="{{ asset('storage/'.$imagen->user_id.'/'.$imagen->src) }}">
                                        <img class="img-fluid rounded"
                                            src="{{ asset('storage/'.$imagen->user_id.'/rescaling/'.$imagen->src) }}"
                                            alt="{{$imagen->src}}">
                                    </a> 
                                </div>
                                @empty
                                <div class="slider-item"><a
                                    href="{{ asset('storage/'.$user_id2->id.'/'.$user_id2->imagen) }}">
                                    <img class="img-fluid rounded"
                                        src="{{ asset('storage/'.$user_id2->id.'/_avatar/'.$user_id2->imagen) }}"
                                        alt="{{$user_id2->imagen}}">
                                </a> 
                            </div>
                                @endforelse
                            </div>
                            <div class="slider-nav">
                                @forelse ($photos_user_id2 as $imagen)
                                <div>
                                    <img class="img-thumbnail" 
                                        src="{{ asset('storage/'.$imagen->user_id.'/rescaling/'.$imagen->src) }}"
                                        alt="{{$imagen->src}}">
                                </div>
                                @empty
                                <div>
                                    <img class="img-thumbnail" 
                                        src="{{ asset('storage/'.$user_id2->id.'/_avatar/'.$user_id2->imagen) }}"
                                        alt="{{$user_id2->imagen}}">
                                </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-md-12">
                               
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('js/home/slick.js')}}"></script>
<script src="{{ asset('js/livechat/livechat.js') }}"></script>
@endsection


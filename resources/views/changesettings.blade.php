@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/home/homestyle.css') }}">
@endsection
@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    @if(session('alert'))
        <div class="alert alert-danger" role="alert">
            {{session('alert')}}
        </div>
    @endif
    <div class="row justify-content-center">

        @include('partials.settings')

        <div class="col-12 col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <p id="titulo-header">Bienvenido a <span style="color: #cc6699">&nbsp;WITH YOU</span></p>
                        {{-- Link para desplegar los settings en la pantalla HOME --}}
                        <a class="nav-link collapse-btn ml-auto text-secondary" data-toggle="collapse" href="#settings" role="button" aria-expanded="false" aria-controls="collapseOne">
                            <i class="fa fa-cog"></i> {{ __('Preferencias') }}</a>
                    </div>
                </div>
               
                <div class="card-body">
                    <div class="row" id="photo-gallery">
                        
                        <div>
                            <img src="{{asset('src/peces.png')}}" alt="peces.png">
                            <h1 style="margin:0 auto; text-align:center;">¡No quedan mas peces en este Mar!
                            <br>Cambia de lugar</h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-3">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center" style="height: 40px;">
                        {{__('Tu lista de matches')}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" id="listamatches">

                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script src="{{asset('js/home/slick.js')}}"></script>
    <script src="{{asset('js/home/jquery.js')}}" ></script>
    <script src="{{asset('js/home/notification.js')}}" ></script>
    <script src="{{asset('js/home/googlemaps.js')}}" ></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhAx57FEzktC4aCuiwo4kLHoJ6snzXukQ&libraries=places&callback=initMap" defer></script>
@endsection


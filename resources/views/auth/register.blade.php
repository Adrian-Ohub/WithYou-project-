@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('css/register/registerstyle.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Bienvenido a <span style="color: #cc6699">WITH YOU</span></div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nombre"
                                class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                        
                            <div class="col-md-6">
                                <input id="nombre" type="text"
                                    class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                    value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>
                        
                                @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apellido1"
                                class="col-md-4 col-form-label text-md-right">{{ __('Primer apellido') }}</label>
                        
                            <div class="col-md-6">
                                <input id="apellido1" type="text"
                                    class="form-control @error('apellido1') is-invalid @enderror"
                                    name="apellido1" value="{{ old('apellido1') }}" required
                                    autocomplete="apellido1" autofocus>
                        
                                @error('apellido1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="fecha_nacimiento"
                                class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento') }}</label>
                        
                            <div class="col-md-6">
                                <input id="fecha_nacimiento" type="date"
                                    class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                    name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                                    autocomplete="fecha_nacimiento" autofocus>
                        
                                @error('fecha_nacimiento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="sexo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Identidad de género') }}</label>
                        
                            <div class="col-md-6">
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="radio1">
                                        <input type="radio" class="form-check-input" id="radio1" name="sexo"
                                            value="hombre" checked>Hombre
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="radio2">
                                        <input type="radio" class="form-check-input" id="radio2" name="sexo"
                                            value="mujer">Mujer
                                    </label>
                                </div>
                                @error('sexo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                        
                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                        
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>
                        
                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">
                        
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirma Contraseña') }}</label>
                        
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="imagen"
                                class="col-md-4 col-form-label text-md-right custom-file-upload">
                                <i class="fas fa-cloud-upload-alt"></i>
                                {{ __('Sube una fotografia tuya') }}</label>
                            <div class="col-md-6">
                                <input id="imagen" type="file"
                                    class="form-control @error('imagen') is-invalid @enderror" name="imagen" accept="image/png, image/jpeg, image/bmp, image/jpg"
                                    value="{{ old('imagen') }}" required autocomplete="imagen" autofocus onchange="PreviewImage()">
                                <img id="uploadPreview" />
                                @error('imagen')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="descripcion"
                                class="col-md-4 col-form-label text-md-right">{{ __('Cuenta algo sobre ti que te describa') }}</label>
                        
                            <div class="col-md-6">
                                <textarea name="descripcion" id="descripcion" cols="75" rows="9"
                                    class="form-control @error('descripcion') is-invalid @enderror"
                                    autocomplete="descripcion" autofocus></textarea>
                        
                                @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> 
                        <div class="form-group row mt-1">
                            <label for="ubicacion"
                                class="col-md-4 col-form-label text-md-right">{{ __('Ubicacion') }}</label>
                        
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="address-reg"
                                    value="" placeholder="p.e. Madrid, España">
                                <input type="hidden" name="place_id" id="place_id" value="">
                                <input type="hidden" name="formatted_address" id="formatted_address"
                                    value="">
                                <input type="hidden" name="lat" id="lat" value="">
                                <input type="hidden" name="lng" id="lng" value="">
                                <span>Selecciona la ubicacion del desplegable</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div id="map-reg" style="width: 100%; height: 200px;"></div>
                    </div>
                </div>
                
                    <div class="form-group row mt-5">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="button" id="submit-register">
                                {{ __('Registrar') }}
                            </button>
                        </div>
                    </div>
                
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('js/register/jquery.js')}}"></script>
<script src="{{asset('js/register/googlemaps.js')}}"></script>
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhAx57FEzktC4aCuiwo4kLHoJ6snzXukQ&libraries=places&callback=initMap" defer></script>   
@endsection
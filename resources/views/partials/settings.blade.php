<div class="accordion" id="myAccordion">
    <div class="card h-100 border-0">
        <div id="settings" class="row collapse justify-content-center" aria-labelledby="headingOne" data-parent="#myAccordion">
            <div class="card-body text-center" style="margin: 0 auto;">
                <form method="POST" action="{{ route('update') }}" id="myForm">
                    @csrf
                    <input type="hidden" name="url-settings" id="url-settings" value="{{ route('update') }}">
                    <div class="card-body">
                        <div id="map" style="width: 100%; height: 200px;"></div>
                    </div>
                    <div class="form-group row">                   
                        <label for="ubicacion" class="col-md-4 col-form-label text-md-right">{{ __('Ubicacion') }}</label>
                        <div class="col-md-6">
                            <div class="form-check-inline">             
                                <input type="text" class="form-control" name="formatted_address" id="formatted_address" value="{{$user->setting->address}}">
                                <input type="hidden" name="place_id" id="place_id" value="{{$user->setting->place_id}}">
                                <input type="hidden" name="lat" id="lat" value="{{$user->setting->lat}}">
                                <input type="hidden" name="lng" id="lng" value="{{$user->setting->lng}}"> 
                            </div>
                        </div> 
                    </div>                    
                    <div class="form-group row">
                        <label for="rango_de_edad" class="col-md-4 col-form-label text-md-right">{{ __('Rango de edad') }}</label>
                        <div class="col-md-6">
                            <div class="form-check-inline">
                                <input type="text" id="rango_edad" readonly style="border:0;">
                                <input type="hidden" id="rango_edad_min" name="rango_edad_min" readonly style="border:0;" value="{{$user->setting->rango_edad_min}}">
                                <input type="hidden" id="rango_edad_max" name="rango_edad_max" readonly style="border:0;" value="{{$user->setting->rango_edad_max}}">
                            </div>
                        </div>
                        <div class="col-md-12 pl-5 pr-5 mt-3">
                            
                            <div id="slider-range"></div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="muestrame" class="col-md-4 col-form-label text-md-right">{{ __('Que buscas') }}</label>

                        <div class="col-md-6">
                            <div class="form-check-inline">
                                <label class="form-check-label" for="radio1">
                                    <input type="radio" class="form-check-input" id="radio1" name="muestrame" value="hombre" {{ $user->setting->muestrame == 'hombre' ? 'checked' : '' }}>Hombre
                                    
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="radio2">
                                    <input type="radio" class="form-check-input" id="radio2" name="muestrame" value="mujer" {{ $user->setting->muestrame == 'mujer' ? 'checked' : '' }}>Mujer
                                    
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="radio3">
                                    <input type="radio" class="form-check-input" id="radio3" name="muestrame" value="todo" {{ $user->setting->muestrame == 'todo' ? 'checked' : '' }}>Todo
                                    
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="button" id="submit-settings">
                                {{ __('Registrar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




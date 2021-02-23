<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="{{asset('src/logo30.png')}}" />
        <title>WITH YOU</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <script src="https://kit.fontawesome.com/2aa1d1cbfd.js" crossorigin="anonymous"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/welcome/welcomestyle.css')}}">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}"><i class="fas fa-home"></i>Home</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            {{ __('Logout') }}
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"><i class="fas fa-edit"></i>registro</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <img src="{{ asset('src/logo180.png') }}" alt="logo180.png" style="width: 150px; height: 150px">
                <div class="title">
                    WITH YOU
                </div>
                <div class="subtitle">
                   busca y encuentra a tu media naranja
                </div>

                <div class="links">
                    @auth
                    <a href="{{ url('/home') }}"><button type="submit">Bienvenid@ {{Auth::user()->nombre}}</button></a>
                    @else
                    <div class="wrapper fadeInDown">
                        <div class="card" id="formContent">
                            
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    @if (session('confirmation'))
                                        <div class="alert alert-info" role="alert">
                                            {!! session('confirmation') !!}
                                        </div>
                                    @endif
            
                                    @if ($errors->has('confirmation') > 0 )
                                        <div class="alert alert-danger" role="alert">
                                            {!! $errors->first('confirmation') !!}
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label">{{ __('E-Mail') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label">{{ __('Contraseña') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Recuerdame') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row mb-0" >
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="fadeIn fourth" id="btn-submit">
                                                {{ __('Login') }}
                                            </button>
                                            
                                        </div>
                                        <div id="formFooter">
                                            @if (Route::has('password.request'))
                                                <a class="underlineHover" href="{{ route('password.request') }}">
                                                    {{ __('Olvidaste la contraseña?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    @endauth

                </div>
            </div>
        </div>
    </body>
</html>

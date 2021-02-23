@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/perfil/perfilstyle.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <!-- inicio parte izquierda - datos personales -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Perfil</div>
                <div class="card-body text-center">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('perfil.update',$user->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input name="_method" type="hidden" value="PATCH">
                                <div class="form-group row justify-content-center">
                                    <div class="card-body">
                                        <div class="card">
                                            <div class="media">
                                                <img src="{{ asset('storage/'.$user->id.'/_avatar/'.$user->imagen) }}"
                                                    class="img mr-3" alt="..." style="width:120px;height:120px;">
                                                <input type="hidden" name="avatarActual" value="{{$user->imagen}}">
                                                <div class="media-body pt-3" align="center">
                                                    <h1>{{ $user->nombre }}</h1>
                                                    <h2>{{ $user->age }} años</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="imagen"
                                        class="col-md-4 col-form-label text-md-right custom-file-upload">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        {{ __('Cambiar foto de perfil') }}</label>
                                    <div class="col-md-6">
                                        <input id="imagen" type="file"
                                            class="form-control @error('imagen') is-invalid @enderror" name="imagen" accept="image/png, image/jpeg, image/bmp, image/jpg"
                                            value="{{ old('imagen') }}" autocomplete="imagen" autofocus onchange="PreviewImage()">
                                        <img id="uploadPreview" />
                                        @error('imagen')
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
                                            autocomplete="email" value="{{$user->email}}">

                                        @error('email')
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
                                        <textarea name="descripcion" id="descripcion" cols="75" rows="10"
                                            class="form-control @error('descripcion') is-invalid @enderror"
                                            autocomplete="descripcion" autofocus>{{$user->descripcion}}</textarea>

                                        @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="button">
                                            {{ __('Guardar cambios') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- final parte izquierda -->
        <!-- inicio parte derecha - galeria de fotos -->
        <div class="col-md-6">
            <div class="card h-100">

                <div class="card-header">{{__('Galeria de fotos')}}</div>

                <div class="card-body">

                    <div class="form-group row">       
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="center">Imagenes cargadas</h3>
                                </div>
                                <br>
                                <div class="panel-body" id="uploaded_image"></div>
                            </div>

                            <form id="dropzoneForm" class="dropzone" action="{{ route('photo.upload') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="dz-message" data-dz-message>
                                    <span><i class="fas fa-cloud-upload-alt" style="font-size:48px;"></i>
                                        <br>
                                        Arrastra y suelta las imagenes o haz click,
                                        despues aprieta "cargar imagenes"
                                    </span>
                                </div>
                            </form>
                            <br>
                            <div align="center">
                                <button type="submit" class="button" id="submit-all">Cargar imagenes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- final parte derecha -->
    <!-- inicio modal  dentro incluimos el form de destroy-->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">Borrar Cuenta</div>
                <div class="card-body">
                    <button class="destroy-button btn btn-danger deleteUser" data-userid="{{$user->id}}">Borrar</button>
                    <div id="UserDeleteModal" class="modal modal-danger fade" tabindex="-1" role="dialog"
                        aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog" style="width:55%;">
                            <div class="modal-content">
                                <form action="{{route('perfil.destroy')}}" method="POST" class="remove-record-model"
                                    id="removeForm">
                                    {{ method_field('post') }}
                                    {{ csrf_field() }}

                                    <div class="modal-header">

                                        <h4 class="modal-title text-center" id="custom-width-modalLabel">¡¡ ATENCION !!
                                        </h4><button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Estas a punto de borrar tu cuenta, se perderan todos los datos asociados a
                                            ella.</h4>
                                        <input type="hidden" name="user_id" id="app_id">
                                    </div>
                                    <div class="modal-footer">
                                        {{-- <button type="button" class="btn btn-default waves-effect"
                                            data-dismiss="modal">Cerrar</button> --}}
                                        <button type="submit"
                                            class="destroy-button btn btn-danger waves-effect remove-data-from-delete-form">Borrar</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- final modal -->
</div>
</div>

<script type="text/javascript">

load_images();

function load_images(){
    $.ajax({
        url:"{{ route('photo.fetch') }}",
        success:function(data)
        {
            $('#uploaded_image').html(data);
        }
    });
}

$(document).on('click', '.remove_image', function(){
    var name = $(this).attr('id');
    $.ajax({
        url:"{{ route('photo.delete') }}",
        data:{name : name},
        success:function(data){
            load_images();
        }
    });
});

$(document).on('click','.deleteUser',function(){
    var userID=$(this).attr('data-userid');
    $('#app_id').val(userID);
    $('#UserDeleteModal').modal('show');
});

function PreviewImage() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("imagen").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("uploadPreview").style.width = "150px";
        document.getElementById("uploadPreview").style.height = "150px";
        document.getElementById("uploadPreview").style.margin = "0px auto";
        document.getElementById("uploadPreview").src = oFREvent.target.result;
        
    };
};
</script>

@endsection
@section('scripts')
    <script src="{{asset('js/perfil/dropzone.js')}}"></script>
@endsection
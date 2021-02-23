{{-- Lista de matches --}}
<div class="col-12 col-md-12 p-0">
    <div class="card-body p-0" style="max-height: 650px; overflow-y: auto;">
        @foreach($list_matches as $mymatches)
        <div class="card-text d-flex justify-content-between align-items-center border border-light rounded p-1 m-1">
            <img class="img-media rounded" src="{{ asset('storage/'.$mymatches->id.'/avatar/'.$mymatches->imagen) }}" alt="{{$mymatches->imagen}}" style="width: 75px; height: 75px;">
            <a class="button" id="btn-chat" href="{{route('livechat.show', $mymatches->id)}}">Chatea con {{$mymatches->nombre}}</a>
        </div>
        @endforeach
    </div>
</div>


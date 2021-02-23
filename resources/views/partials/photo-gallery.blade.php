<div class="col-12 col-md-7">
    <div class="slider-content">
        @forelse ($photos_user_random as $imagen)
        <div class="slider-item"><a
                href="{{ asset('storage/'.$imagen->user_id.'/'.$imagen->src) }}">
                <img class="img-fluid rounded"
                    src="{{ asset('storage/'.$imagen->user_id.'/rescaling/'.$imagen->src) }}"
                    alt="{{$imagen->src}}">
            </a> 
        </div>
        @empty
        <div class="slider-item"><a
            href="{{ asset('storage/'.$user_random->id.'/'.$user_random->imagen) }}">
            <img class="img-fluid rounded"
                src="{{ asset('storage/'.$user_random->id.'/_avatar/'.$user_random->imagen) }}"
                alt="{{$user_random->imagen}}">
        </a> 
    </div>
        @endforelse
    </div>
    <div class="slider-nav">
        @forelse ($photos_user_random as $imagen)
        <div>
            <img class="img-thumbnail" 
                src="{{ asset('storage/'.$imagen->user_id.'/rescaling/'.$imagen->src) }}"
                alt="{{$imagen->src}}">
        </div>
        @empty
        <div>
            <img class="img-thumbnail" 
                src="{{ asset('storage/'.$user_random->id.'/_avatar/'.$user_random->imagen) }}"
                alt="{{$user_random->imagen}}">
        </div>
        @endforelse
    </div>
</div>
<div class="col-md-1"></div>
<div class="col-12 order-first order-md-0 col-md-4 mb-2">
    <div class="card h-100 border-0">
        <img class="card-img-top"
            src="{{ asset('storage/'.$user_random->id.'/_avatar/'.$user_random->imagen) }}"
            alt="{{$user_random->imagen}}">
        <div class="card-body">
            <h4 class="card-title">{{$user_random->nombre}} - {{$user_random->age}} años</h4>
            <p>Descripcion:</p>
            <p class="card-text" style="height: 150px">{{$user_random->descripcion}}</p>
        </div>
        <div class="row pl-2 pr-2" style="text-align: center">
            <form action="{{route('like')}}" method="POST">
                @csrf
                <input type="hidden" name="url-like" id="url-like" value="{{route('like')}}" />
                <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                <input type="hidden" name="user_id2" id="user_id2" value="{{$user_random->id}}">
            </form>
            <form action="{{route('dislike')}}" method="POST">
                @csrf
                <input type="hidden" name="url-dislike" id="url-dislike" value="{{route('dislike')}}" />
            </form>
                    
            <div class="like mr-auto rounded-circle p-2">
                <i type="button" class="fas fa-heart" id="like_request"></i>
            </div>
            
            <div class="dislike ml-auto rounded-circle p-2">
                <i type="button" class="fas fa-heart-broken" id="dislike_request"></i>
            </div>
            
        </div>

    </div>
</div>



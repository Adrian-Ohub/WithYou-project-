<a class="dropdown-item" href="{{route('livechat.show',$noRead->data['user']['id'])}}">
    <span>
    <i class="fas fa-exclamation"></i>
    Tienes un match de <b>{{ $noRead->data['user']['nombre']}} WITH YOU!</b> 
    </span>
</a>
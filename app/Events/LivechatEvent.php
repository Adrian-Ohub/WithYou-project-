<?php

namespace App\Events;
 
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Livechat;
use App\User;
 
class LivechatEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;



    public $mensaje;
    public $user;
    public $canal;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Livechat $mensaje, User $user, $canal)
    {

        $this->mensaje = $mensaje;
        $this->user = $user;
        $this->canal = $canal;
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('LiveChat.'.$this->canal);
    }
}

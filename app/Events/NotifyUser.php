<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NotifyUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $user_uid;
    protected $order_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_uid, $order_id)
    {
        //
        $this->user_uid = $user_uid;
        $this->order_id = $order_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('order-update-'.$this->user_uid);
    }

    public function broadcastAs() {
        return 'notification';
    }

    public function broadcastWith() {
        return [
            'order_id' => $this->order_id
        ];
    }

}

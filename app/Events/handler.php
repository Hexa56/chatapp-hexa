<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class handler implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $fname;
    public $msg;
    public $reciver;
    public $time;
    public $id;
    public $dd;
    public $user_id;
    public $reply;
    public $rid;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $fname, $msg, $reciver, $time, $id, $dd, $user_id,$reply,$rid)
    {
        $this->sender = $name;
        $this->fname = $fname;
        $this->msg = $msg;
        $this->reciver = $reciver;
        $this->time = $time;
        $this->id = $id;
        $this->dd = $dd;
        $this->user_id = $user_id;
        $this->reply = $reply;
        $this->rid = $rid;


    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }
    public function broadcastAs()
    {
        return 'msg';
    }
}

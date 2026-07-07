<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserNotification implements ShouldBroadcast
{
    use SerializesModels;

    public $title;
    public $message;
    public $type;
    public $userId;
    public $sentBy;
    public $data;


    public function __construct($userId, $sentBy, $title, $message, $type = 'info', $data = null)
    {
        $this->userId = $userId;
        $this->sentBy = $sentBy;
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->userId);
    }
}

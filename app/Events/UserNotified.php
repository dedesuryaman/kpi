<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserNotified implements ShouldBroadcast
{
public function __construct(
public int $userId,
public array $data
) {}

public function broadcastOn()
{
return new PrivateChannel('user.' . $this->userId);
}
}
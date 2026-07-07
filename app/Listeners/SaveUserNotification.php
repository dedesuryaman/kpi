<?php

namespace App\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\UserNotification;
use App\Models\Notification;

class SaveUserNotification
{
    public function handle(UserNotification $event)
    {
        Notification::create([
            'user_id'   => $event->userId,
            'sent_by'   => $event->sentBy,
            'title'     => $event->title,
            'message'   => $event->message,
            'type'      => $event->type,
            'data'      => $event->data ? json_encode($event->data) : null,
            'is_read'   => 0,
            'sent_at'   => now(),
        ]);
    }
}

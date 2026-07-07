<?php

namespace App\Http\Controllers;

use DevKandil\NotiFire\Facades\Fcm;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class NotifikasiController extends Controller
{
    public function __construct()
    {


        $this->middleware('auth');
    }

    public function test(FirebaseService $firebase)
    {
        $fcmToken = Auth::user()->fcm_token;
        return $firebase->sendToToken(
            $fcmToken,
            'Notifikasi Test',
            'FCM Laravel berhasil',
            ['type' => 'test']
        );
        // Simple notification
        $success = Fcm::withTitle('Hello')
            ->withBody('This is a test notification')
            ->sendNotification($fcmToken);

        if ($success) {
            // Notification sent successfully
            return 1;
        }
        return 0;
    }
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }
    public function testSend(FirebaseService $firebase)
    {
        $token = 'cwnQtqEOZfbTJv9237LgzW:APA91bFZhAa4lSNWYh6yXlr8n4uaN3KJHC52W9PcfzJ2eHKVWcyQS5SpVSRRa6JuWBdYLrozK3fu3jYa7g7YN17i4n7njcHi55fs5hDQPGjQx-WQi8k-BHw';

        return (new FcmMessage(notification: new FcmNotification(
            title: 'Account Activated',
            body: 'Your account has been activated.',
            image: 'http://example.com/url-to-image-here.png'
        )))
            ->data(['data1' => 'value', 'data2' => 'value2'])
            ->custom([
                'android' => [
                    'notification' => [
                        'color' => '#0A0A0A',
                        'sound' => 'default',
                    ],
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default'
                        ],
                    ],
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
            ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // Tampilkan halaman chat
    public function index()
    {
        return view('chat');
    }

    // Kirim pesan
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

 
        $message = $request->message;

        // Broadcast event
      // broadcast(new NewMessage($message))->toOthers();
	   
	   
	   
	    broadcast(new MessageSent($message))->toOthers();
		
		//event(new NewMessage($message));
        return response()->json(['status' => 'ok']);
    }
}

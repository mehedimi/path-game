<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Game;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Game $game)
    {
        return $game->messages()->with('user')->get();
    }

    public function store(Request $request, Game $game)
    {
        /** @var Message $message */
        $message = $game->messages()->create([
            'message' => $request->message,
            'user_id' => $request->user()->id,
            'created_at' => now()
        ]);

        broadcast(new NewMessageEvent([
            'game' => $game,
            'message' => $message->load('user')
        ]));

        return response([
            'success' => true
        ]);
    }
}

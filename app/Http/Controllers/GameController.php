<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function invite()
    {
        return view('game.invite');
    }

    public function sendInvitation(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        /** @var Game $game */
        $game = Game::create([]);

        $game->users()->attach([auth()->id(), $request->get('id')]);

        return response([
            'gameUrl' => route('game.play', $game)
        ]);
    }

    public function play(Game $game)
    {
        return view('game.play', compact('game'));
    }

    public function sendMessage(Game $game, Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);
    }
}

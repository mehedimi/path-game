<?php

namespace App\Http\Controllers;

use App\Events\GameMoveEvent;
use App\Game;
use App\GameMove;
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
        $game = Game::create([
            'turnner_id' => auth()->id()
        ]);

        for ($i = 0; $i < 9; $i++) {
            if($i === 3) {
                $i = 6;
            }
            $game->gameMoves()->create(
                $this->defaultGameMoves(auth()->id(), $request->get('id'), $i)
            );
        }

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

    protected function defaultGameMoves($userId, $opponentId, $index)
    {
        return [
            'index' => $index,
            'user_id' => ($index <= 2 ? $userId : $opponentId),
        ];
    }
}

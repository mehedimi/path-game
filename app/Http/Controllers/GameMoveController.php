<?php

namespace App\Http\Controllers;

use App\Events\GameMoveEvent;
use App\Game;
use App\GameMove;
use App\User;
use Illuminate\Http\Request;

class GameMoveController extends Controller
{
    public function index(Game $game)
    {
        return $game->gameMoves;
    }

    public function update(Request $request, Game $game, GameMove $gameMove)
    {
        /** @var User $turnner */
        $turnner = $game->users()->where('id', '<>', $game->turnner_id)->first();

        $prevIndex = $gameMove->index;

        $game->update([
            'turnner_id' => $turnner->id
        ]);
        /** @var GameMove $move */
        $gameMove->update([
            'index' => $request->index
        ]);

        broadcast(new GameMoveEvent([
            'turnner_id' => $turnner->id,
            'move' => $gameMove,
            'previousIndex' => $prevIndex
        ]));

        return response([
            'message' => 'Success'
        ]);
    }
}

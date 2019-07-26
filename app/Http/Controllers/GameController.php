<?php

namespace App\Http\Controllers;

use App\Events\EndGameEvent;
use App\Events\InviteEvent;
use App\Game;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

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

        broadcast(new InviteEvent($game->load('user')));

        return response([
            'gameUrl' => route('game.play', $game)
        ]);
    }

    /**
     * @param Game $game
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function play(Game $game)
    {
        $this->authorize('index', $game);

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

    /**
     * @param Game $game
     * @param Request $request
     * @return ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function end(Game $game, Request $request)
    {
        $this->authorize('index', $game);

        $game->update([
            'winner_id' => $request->user()->id,
            'line_index' => $request->index
        ]);

        broadcast(new EndGameEvent($game));

        return response([
            'game' => $game
        ]);

    }
}

<?php

namespace App\Policies;

use App\Game;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    public function index(User $user, Game $game)
    {
        return in_array($user->id, $game->users->pluck('id')->toArray());
    }

    public function destroy(User $user, Game $game)
    {
        return $this->view($user, $game);
    }
}

<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\User;
use App\Game;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(/**
 * @param User $user
 * @param Game $game
 * @return array
 */ 'game.{game}', function ($user, Game $game) {
    return [
        'id' => $user->id,
        'name' => $user->name
    ];
});

Broadcast::channel('users.{user}', function ($u, $user){
    return true;
});

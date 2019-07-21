<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function (){
    Route::get('play/{game}', 'GameController@play')->name('game.play');

    Route::get('invite', 'GameController@invite');

    Route::post('invite', 'GameController@sendInvitation');

    Route::get('users', 'UserController@index');

    Route::get('games/{game}/moves', 'GameMoveController@index');
    Route::put('games/{game}/moves/{gameMove}', 'GameMoveController@update');

    Route::get('games/{game}/messages', 'MessageController@index');
    Route::post('games/{game}/messages', 'MessageController@store');
});



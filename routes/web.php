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
});



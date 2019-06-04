@extends('layouts.app')

@section('content')
    <div class="container">
        <game-body :game-id="{{ $game->id }}"></game-body>
    </div>
@endsection

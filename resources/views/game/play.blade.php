@extends('layouts.app')

@section('content')
    <div class="container">
        <game-body :game="{{ $game }}" :game-users="{{ $game->users }}" :me-id="{{ auth()->id() }}"></game-body>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Games
                </h1>
            </div>
        </div>
    </section>
    <div class="container mt-50">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Winner</th>
                    <th>Started At</th>
                    <th>Last Played At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            @foreach($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>{{ $game->winner->name ?? "---" }}</td>
                    <td>{{ $game->created_at->diffForHumans() }}</td>
                    <td>{{ $game->updated_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('game.play', $game) }}">Play</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $games->links('pagination.bulma') !!}

        <div>
            <invitation user-id="{{ auth()->id() }}"></invitation>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-centered mt-40">
            <div class="column is-7 has-text-centered">
                <figure class="image">
                    <img src="/images/home-page.gif" alt="Home Page">
                </figure>
                <a href="/invite" class="button is-large mt-20 is-primary">Play Now</a>
            </div>
        </div>
        @if(auth()->check())
            <div>
                <invitation user-id="{{ auth()->id() }}"></invitation>
            </div>
        @endif
    </div>
@endsection

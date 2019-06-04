@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Registration
                    </p>
                </header>
                <div class="card-content">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="field">
                            <label for="name" class="label">Name</label>
                            <div class="control">
                                <input id="name" name="name" value="{{ old('name') }}" class="input @error('name') is-danger @enderror" type="text" placeholder="Enter your full name">
                            </div>
                            @error('name')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="email" class="label">Email</label>
                            <div class="control">
                                <input id="email" name="email" value="{{ old('email') }}" class="input @error('email') is-danger @enderror" type="text" placeholder="Enter email">
                            </div>
                            @error('email')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password" class="label">Password</label>
                            <div class="control">
                                <input id="password" name="password" class="input @error('password') is-danger @enderror" type="text" placeholder="Password">
                            </div>
                            @error('password')
                            <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password_confirmation" class="label">Confirm Password</label>
                            <div class="control">
                                <input id="password_confirmation" name="password_confirmation" class="input" type="text" placeholder="Password confirmation">
                            </div>
                        </div>

                        <div class="field">
                            <button class="button is-primary">Register</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

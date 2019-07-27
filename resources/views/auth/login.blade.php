@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content mt-20">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Login
                        </p>
                    </header>
                    <div class="card-content">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="field">
                                <label for="email" class="label">Email</label>
                                <div class="control has-icons-left">
                                    <input id="email" type="text" value="{{ old('email') }}" placeholder="Enter your registered email" name="email" class="input @error('email') is-danger @enderror">
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                </div>
                                @error('email')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="password" class="label">Password</label>
                                <div class="control has-icons-left">
                                    <input id="password" type="password" placeholder="Enter your registered password" name="password" class="input @error('password') is-danger @enderror">
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                                @error('password')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="field">
                                <label class="checkbox">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    Remember me
                                </label>
                            </div>

                            <div class="field is-grouped">
                                <div class="control">
                                    <button class="button is-primary">Login</button>
                                </div>
                                @if (Route::has('password.request'))
                                    <div class="control">
                                        <a href="{{ route('password.request') }}" class="button is-text">Forgot password?</a>
                                    </div>
                                @endif
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav-bar inline-template>
            <nav class="navbar" role="navigation" aria-label="main navigation">
                <div class="container">
                    <div class="navbar-brand">
                        <a class="navbar-item" href="/home">
                            <img src="/images/logo.svg" width="200" height="28">
                        </a>

                        <a role="button" @click="isActive = !isActive" :class="{'is-active': isActive}" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                            <span aria-hidden="true"></span>
                            <span aria-hidden="true"></span>
                            <span aria-hidden="true"></span>
                        </a>
                    </div>

                    <div id="navbarBasicExample" :class="{'is-active': isActive}" class="navbar-menu">
                        @guest
                            <div class="navbar-end">
                                <div class="navbar-item">
                                    <div class="buttons">
                                        <a href="/register" class="button is-primary">
                                            <strong>Sign up</strong>
                                        </a>
                                        <a href="/login" class="button is-light">
                                            Log in
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="navbar-end">
                                <a href="#" class="navbar-item">
                                    Play
                                </a>
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link">
                                        {{ auth()->user()->name }}
                                    </a>
                                    <div class="navbar-dropdown">
                                        <a class="navbar-item">
                                            About
                                        </a>
                                        <a class="navbar-item">
                                            Jobs
                                        </a>
                                        <a class="navbar-item">
                                            Contact
                                        </a>
                                        <hr class="navbar-divider">
                                        <a onclick="document.getElementById('logout').submit();" class="navbar-item">
                                            Logout
                                        </a>
                                    </div>
                                    <form id="logout" action="/logout" method="post">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>

            </nav>
        </nav-bar>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

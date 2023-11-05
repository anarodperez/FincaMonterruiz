@extends('layouts.guest')

@section('title')
    Iniciar sesión
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="wrapper">
        <div class="container-formulario">
            <div class="signup"><strong>Iniciar sesión</strong></div>
            <div class="login"><strong><a class="enlace" href="{{ route('register') }}"> Registrate </a></strong></div>

            <div class="login-form" style="background: white">
                <img src="imagenes/img1.jpg" alt="Imagen" class=" img-fluid login-image">
                <form method="POST" action="{{ route('login') }}" id="login-box">
                    @csrf
                    <h3>Iniciar sesión</h3>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="input" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="input" type="password" name="password" required
                            autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Recuérdame') }}</span>
                        </label>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('¿Has olvidado la contraseña?') }}
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="btn-2">Entrar</button>
                </form>
            </div>
        </div>
    </div>
@endsection



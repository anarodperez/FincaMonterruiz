@extends('layouts.guest')

@section('title')
    Iniciar sesión
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

<script defer>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

@section('content')
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="wrapper">
        <div class="container-formulario">
            <div class="signup"><strong>Iniciar sesión</strong></div>
            <div class="login"><strong><a class="enlace" href="{{ route('register') }}"> Registrate </a></strong></div>

            <div class="login-form" style="background: white">
                <img src="img/img1.jpg" alt="Imagen" class=" img-fluid login-image">
                <h3>Iniciar sesión</h3>
                <a href="{{ url('/login/google') }}" class="boton-google">
                    <i class="fab fa-google" aria-hidden="true"></i> Iniciar sesión con Google
                </a>

                @if (session('status') === 'login-error')
                    <div class="alert alert-danger">
                        No estás autorizado para acceder. Por favor, verifica tu cuenta.
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="login-box">
                    @csrf
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="input" type="email" name="email" :value="old('email')" required
                            autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4" style="position: relative;">
                        <x-input-label for="password" :value="__('Password')" />

                        <div class="input-group">
                            <x-text-input id="password" class="input" type="password" name="password" required
                                autocomplete="current-password" />
                            <span class="password-toggle" onclick="togglePasswordVisibility()">
                                <!-- Ícono para alternar la visibilidad de la contraseña -->
                                <i id="toggleIcon" class="fas fa-eye"></i>
                            </span>
                        </div>
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
                                {{ __('¿Has olvidado la contraseña? Haz click en este enlace.') }}
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="btn-2">ACCEDER</button>
                </form>
            </div>
        </div>
    </div>
@endsection

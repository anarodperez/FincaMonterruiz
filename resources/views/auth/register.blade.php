@extends('layouts.guest')
@section('title')
    Registro
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <script src="{{ asset('js/validaciones.js') }}" defer></script>
    <style>
        .container-formulario {
            width: 50%;
            text-align: center;
        }

        label[for="nombre"]:after,
        label[for="apellido1"]:after,
        label[for="email"]:after,
        label[for="password"]:after,
        label[for="password_confirmation"]:after {
            content: "*";
            color: red;
        }

        .col-md-3 {
            padding-bottom: 3vh;
        }

        @media (max-width: 768px) {

            .signup,
            .login {
                width: 55vw;
            }
        }

        .password-toggle {
            top: 61%;
            right: 16px;
            font-size: 1.3em;

        }
    </style>
@endsection
<script defer>
    function togglePasswordVisibility(passwordInputId, toggleIconId) {
        const passwordInput = document.getElementById(passwordInputId);
        const icon = document.getElementById(toggleIconId);

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
        <section class="container-formulario">
            <div class="signup"><strong>Registrarse</strong></div>
            <div class="login"><strong><a class="enlace" href="{{ route('login') }}">Iniciar sesión</a></strong></div>
        </section>
        <div class="container shadow-lg p-3 mb-5 bg-body rounded " style="min-height: 50vh">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3>Registro de Usuario</h3>
            <form class="row g-3" method="POST" action="{{ route('register') }}" autocomplete="off" id="form">
                @csrf
                <!-- Nombre -->
                <div class="col-md-3">
                    <x-input-label for="nombre" :value="__('Nombre')" class="form-label" />
                    <x-text-input id="nombre" class="form-control" type="text" name="nombre" :value="old('nombre')"
                        autofocus autocomplete="nombre" />
                    <x-input-error :messages="$errors->get('nombre')" class=" badge text-danger errors-nombre" />
                </div>
                <!-- Apellido1 -->
                <div class="col-md-3">
                    <x-input-label for="apellido1" :value="__('Primer apellido')" class="form-label" />
                    <x-text-input id="apellido1" class="form-control" type="text" name="apellido1" :value="old('apellido1')"
                        autofocus autocomplete="apellido1" />
                    <x-input-error :messages="$errors->get('apellido1')" class=" badge text-danger errors-apellido1" />
                </div>
                <!-- Apellido2 -->
                <div class="col-md-3">
                    <x-input-label for="apellido2" :value="__('Segundo apellido')" class="form-label" />
                    <x-text-input id="apellido2" class="form-control" type="text" name="apellido2" :value="old('apellido2')"
                        autofocus autocomplete="apellido2" />
                    <x-input-error :messages="$errors->get('apellido2')" class=" badge text-danger errors-apellido2" />
                </div>
                <!-- Email -->
                <div class="col-md-3">
                    <x-input-label for="email" :value="__('Email')" class="form-label" />
                    <x-text-input id="email" class="form-control" type="text" name="email" :value="old('email')"
                        autofocus autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class=" badge text-danger errors-email" />
                </div>
                <!-- Contraseña -->
                <div class="col-md-3" style="position: relative;">
                    <x-input-label for="password" :value="__('Contraseña')" class="form-label" />
                    <x-text-input id="password" class="form-control" type="password" name="password" required
                        autocomplete="new-password" />
                    <span class="password-toggle" onclick="togglePasswordVisibility('password', 'toggleIconRegister')">
                        <i id="toggleIconRegister" class="fas fa-eye"></i>
                    </span>
                    <x-input-error :messages="$errors->get('password')" class=" badge text-danger errors-password" />
                </div>

                <!-- Confirmación de Contraseña -->
                <div class="col-md-3" style="position: relative;">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="form-label" />
                    <x-text-input id="password_confirmation" class="form-control" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <span class="password-toggle"
                        onclick="togglePasswordVisibility('password_confirmation', 'toggleIconConfirmRegister')">
                        <i id="toggleIconConfirmRegister" class="fas fa-eye"></i>
                    </span>
                    <x-input-error :messages="$errors->get('password_confirmation')" class=" badge text-danger errors-password_confirmation" />
                </div>



                <div class="col-12" style="text-align: center;">
                    <button type="submit" id="btn-enviar" class="btn-2" style="width: 200px;">REGISTRARSE</button>
                </div>
            </form>
        </div>
    </div>
@endsection

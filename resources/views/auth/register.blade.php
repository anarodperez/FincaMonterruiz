@extends('layouts.guest')
@section('title')
    Registro
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    {{-- <script src="{{ asset('js/validaciones.js') }}" defer></script> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&display=swap">

    <style>
        body {
            font-family: 'Josefin Sans', sans-serif;
        }

        .signup,
        .login {
            width: 50%;
            display: inline-block;
            text-align: center;
            margin: 2em 0;
        }

        .container-formulario {
            width: 50%;
            text-align: center;
        }

        label[for="nombre"]:after,
        label[for="apellido1"]:after,
        label[for="email"]:after,
        label[for="password"]:after {
            content: "*";
            color: red;
        }
    </style>
@endsection

@section('content')
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="wrapper">
        <div class="container-formulario">
            <div class="signup"><strong>Registrarse</strong></div>
            <div class="login"><strong><a class="enlace" href="{{ route('login') }}">Iniciar sesión</a></strong></div>
        </div>
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
                <div class="col-md-3">
                    <x-input-label for="password" :value="__('Contraseña')" class="form-label" />
                    <x-text-input id="password" class="form-control" type="password" name="password" :value="old('password')"
                        autofocus autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class=" badge text-danger errors-password" />
                </div>
                <!-- Campo de confirmación de contraseña -->
                <div class="col-md-3">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="form-label" />
                    <x-text-input id="password_confirmation" class="form-control" type="password"
                        name="password_confirmation" :value="old('password_confirmation')" autofocus autocomplete="password_confirmation" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class=" badge text-danger errors-password_confirmation" />
                </div>

                <div class="col-12" style="text-align: center;">
                    <button type="submit" id="btn-enviar" class="btn-2" style="width: 200px;">REGISTRARSE</button>
                </div>
            </form>
            <script defer>
                document.addEventListener("DOMContentLoaded", function() {
                    const registerForm = document.getElementById('form');
                    registerForm.addEventListener('submit', function(event) {
                        event.preventDefault();

                        const fieldsToValidate = [{
                                inputId: 'nombre',
                                errorMessage: 'Nombre no válido. Introduce un nombre válido.'
                            },
                            {
                                inputId: 'apellido1',
                                errorMessage: 'Apellido no válido. Introduce tu apellido.'
                            },
                            {
                                inputId: 'apellido2',
                                errorMessage: 'Apellido no válido. '
                            },
                            {
                                inputId: 'email',
                                errorMessage: 'Formato de email no válido.'
                            },
                            {
                                inputId: 'password',
                                errorMessage: 'La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número.'
                            }
                        ];

                        let errors = false;

                        fieldsToValidate.forEach(field => {
                            const input = document.getElementById(field.inputId);
                            if (!validateField(input, field.errorMessage)) {
                                errors = true;
                            }
                        });

                        if (!errors) {
                            registerForm.submit();
                        }
                    });

                    function validateField(input, errorMessage) {
                        if (!input) {
                            return false; // Si el elemento es nulo, salir de la función
                        }

                        if ((!input.value || input.value.trim().length < 1) && input.id !== 'apellido2') {
                            showError(input, 'Este campo es requerido');
                            return false;
                        } else if ((input.id === 'nombre' && (input.value.length < 3 || !validarInput(input.value))) ||
                            (input.id === 'apellido1' && (input.value.length < 5 || !validarInput(input.value))) ||
                            (input.id === 'apellido2' && (input.value.length > 0 && input.value.length < 5 && !validarInput(input.value))) ||
                            (input.id === 'email' && (input.value.length < 10 || !isValidEmail(input.value))) ||
                            (input.id === 'password' && !validarContraseña(input.value))
                        ) {
                            showError(input, errorMessage);
                            return false;
                        } else {
                            hideError(input);
                            return true;
                        }
                    }

                    function showError(input, message) {
                        const errorSpan = input.parentElement.querySelector('.errors-' + input.id);
                        if (errorSpan) {
                            errorSpan.innerHTML = `<span class="error-icon">❌</span> ${message}`;
                            input.classList.add('is-invalid');
                            errorSpan.classList.add('error-visible');
                            errorSpan.classList.remove('error-hidden');
                        } else {
                            const newErrorSpan = document.createElement('span');
                            newErrorSpan.classList.add('errors-' + input.id);
                            newErrorSpan.innerHTML = `<span class="error-icon">❌</span> ${message}`;
                            input.parentElement.appendChild(newErrorSpan);
                            input.classList.add('is-invalid');
                            newErrorSpan.classList.add('error-visible');
                            newErrorSpan.classList.remove('error-hidden');
                        }
                    }

                    function hideError(input) {
                        if (input) {
                            const errorSpan = input.parentElement.querySelector('.errors-' + input.id);
                            if (errorSpan) {
                                errorSpan.innerHTML = `<span class="valid-icon">✔️</span>`;
                                input.classList.remove('is-invalid');
                                errorSpan.classList.add('error-hidden');
                                errorSpan.classList.remove('error-visible');
                            }
                        }
                    }

                    function isValidEmail(email) {
                        const emailRegex = /^[^\s@]{5,}@[^.\s@]{4,}\.[^.\s@]{2,}$/;
                        return emailRegex.test(email);
                    }

                    function validarInput(input) {
                        const regex = /^[a-zA-ZñÑáéíóúü\s-]+$/;
                        return regex.test(input);
                    }

                    function validarContraseña(password) {
                        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
                        return regex.test(password);
                    }

                    const passwordInput = document.getElementById('password');
                    const passwordConfirmationInput = document.getElementById('password_confirmation');

                    if (passwordInput.value !== passwordConfirmationInput.value) {
                        showError(passwordConfirmationInput, 'Las contraseñas no coinciden');
                        errors = true;
                    }

                });
            </script>

        </div>
    </div>
@endsection

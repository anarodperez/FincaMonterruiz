@extends('layouts.guest')
@section('title')
    Registro
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    {{-- <script src="{{ asset('js/validaciones.js') }}" defer></script> --}}
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

        .col-md-3{
            padding-bottom: 3vh;
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
                    // Obtención del formulario y establecimiento del evento 'submit'
                    const registerForm = document.getElementById('form');
                    registerForm.addEventListener('submit', function(event) {
                        event.preventDefault(); // Evita que el formulario se envíe automáticamente

                        // Array con campos a validar y mensajes de error asociados
                        const fieldsToValidate = [{
                                inputId: 'nombre',
                                errorMessage: 'Nombre no válido. Introduce un nombre válido.'
                            },
                            {
                                inputId: 'apellido1',
                                errorMessage: 'Apellido no válido. Introduce tu primer apellido.'
                            },
                            {
                                inputId: 'apellido2',
                                errorMessage: 'Apellido no válido. Introduce tu segundo apellido. '
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

                        let errors = false; // Inicialización de la variable de error

                        // Validación de cada campo
                        fieldsToValidate.forEach(field => {
                            const input = document.getElementById(field.inputId);
                            if (!validateField(input, field.errorMessage)) {
                                errors = true;
                            }
                        });

                        // Verificación de la igualdad entre las contraseñas
                        const passwordInput = document.getElementById('password');
                        const passwordConfirmationInput = document.getElementById('password_confirmation');

                        if (passwordInput.value !== passwordConfirmationInput.value) {
                            showError(passwordConfirmationInput, 'Las contraseñas no coinciden');
                            errors = true;
                        } else if (passwordConfirmationInput.value.trim().length < 1) {
                            showError(passwordConfirmationInput, 'Este campo es requerido');
                            errors = true;
                        } else {
                            hideError(passwordConfirmationInput); // Ocultar el error si las contraseñas coinciden
                        }

                        // Envío del formulario si no hay errores
                        if (!errors) {
                            registerForm.submit();
                        }
                    });

                    // Validación de un campo específico con su mensaje de error
                    function validateField(input, errorMessage) {
                        if (!input) {
                            return false; // Salir de la función si el elemento es nulo
                        }

                        // Verificación de cada campo según su validación específica
                        if ((!input.value || input.value.trim().length < 1) && input.id !== 'apellido2') {
                            showError(input, 'Este campo es requerido');
                            return false;
                        } else if (
                            (input.id === 'nombre' && (input.value.length < 3 || !validarInput(input.value))) ||
                            (input.id === 'apellido1' && (input.value.length < 5 || !validarInput(input.value))) ||
                            (input.id === 'apellido2' && input.value.trim().length > 0 && (input.value.length < 5 || !
                                validarInput(input.value))) ||
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

                    // Muestra un mensaje de error para un campo específico
                    function showError(input, message) {
                        const errorSpan = createOrGetErrorSpan(input);
                        errorSpan.innerHTML = `<span class="error-icon">❌</span> ${message}`;
                        input.classList.add('is-invalid');
                        errorSpan.classList.add('error-visible');
                        errorSpan.classList.remove('error-hidden');
                    }

                    // Oculta un mensaje de error para un campo específico
                    function hideError(input) {
                        const errorSpan = input.nextElementSibling;
                        if (errorSpan && errorSpan.classList.contains('error-message')) {
                            input.classList.remove('is-invalid');
                            errorSpan.remove();
                        }
                    }

                    // Crea un elemento de mensaje de error o devuelve el existente si ya está creado
                    function createOrGetErrorSpan(input) {
                        let errorSpan = input.nextElementSibling;
                        if (!errorSpan || !errorSpan.classList.contains('error-message')) {
                            errorSpan = document.createElement('span');
                            errorSpan.classList.add('error-message');
                            input.parentNode.insertBefore(errorSpan, input.nextElementSibling);
                        }
                        return errorSpan;
                    }

                    // Función para validar si el email es válido
                    function isValidEmail(email) {
                        const emailRegex = /^[^\s@]{5,}@[^.\s@]{4,}\.[^.\s@]{2,}$/;
                        return emailRegex.test(email);
                    }

                    // Función para validar si la entrada es un apellido válido
                    function validarInput(input) {
                        const regex = /^[a-zA-ZñÑáéíóúü\s-]+$/;
                        return regex.test(input);
                    }

                    // Función para validar si la contraseña es segura
                    function validarContraseña(password) {
                        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
                        return regex.test(password);
                    }
                });
            </script>
        </div>
    </div>
@endsection

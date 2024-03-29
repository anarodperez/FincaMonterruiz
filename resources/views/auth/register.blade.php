@extends('layouts.guest')
@section('title')
    Registro
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <script src="{{ asset('js/validaciones.js') }}" defer></script>
@endsection

@section('content')
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="wrapper registro">
        <div class="container-formulario">
            <div class="signup"><strong>Registrarse</strong></div>
            <div class="login"><strong><a class="enlace" href="{{ route('login') }}">Iniciar sesión</a></strong></div>
        </div>
        <div class="container shadow-lg p-3 mb-5 bg-body rounded " style="min-height: 50vh">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    {{-- <x-input-error :messages="$errors->get('nombre')" class=" badge text-danger errors-nombre" /> --}}
                </div>
                <!-- Apellido1 -->
                <div class="col-md-3">
                    <x-input-label for="apellido1" :value="__('Primer apellido')" class="form-label" />
                    <x-text-input id="apellido1" class="form-control" type="text" name="apellido1" :value="old('apellido1')"
                        autofocus autocomplete="apellido1" />
                    {{-- <x-input-error :messages="$errors->get('apellido1')" class=" badge text-danger errors-apellido1" /> --}}
                </div>
                <!-- Apellido2 -->
                <div class="col-md-3">
                    <x-input-label for="apellido2" :value="__('Segundo apellido')" class="form-label" />
                    <x-text-input id="apellido2" class="form-control" type="text" name="apellido2" :value="old('apellido2')"
                        autofocus autocomplete="apellido2" />
                    {{-- <x-input-error :messages="$errors->get('apellido2')" class=" badge text-danger errors-apellido2" /> --}}
                </div>
                <!-- Email -->
                <div class="col-md-3">
                    <x-input-label for="email" :value="__('Email')" class="form-label" />
                    <x-text-input id="email" class="form-control" type="text" name="email" :value="old('email')"
                        autofocus autocomplete="email" />
                    {{-- <x-input-error :messages="$errors->get('email')" class=" badge text-danger errors-email" /> --}}
                </div>
                <!-- Contraseña -->
                <div class="col-md-3">
                    <x-input-label for="password" :value="__('Contraseña')" class="form-label" />
                    <x-text-input id="password" class="form-control" type="password" name="password" :value="old('password')"
                        autofocus autocomplete="new-password" />
                    {{-- <x-input-error :messages="$errors->get('password')" class=" badge text-danger errors-password" /> --}}
                </div>
                <!-- Campo de confirmación de contraseña -->
                <div class="col-md-3">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="form-label" />
                    <x-text-input id="password_confirmation" class="form-control" type="password"
                        name="password_confirmation" :value="old('password_confirmation')" autofocus autocomplete="password_confirmation" />
                    {{-- <x-input-error :messages="$errors->get('password_confirmation')" class=" badge text-danger errors-password_confirmation" /> --}}
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="col-md-3">
                    <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" class="form-label" />
                    <x-text-input id="fecha_nacimiento" class="form-control" type="date" name="fecha_nacimiento"
                        :value="old('fecha_nacimiento')" autofocus />
                    {{-- <x-input-error :messages="$errors->get('fecha_nacimiento')" class=" badge text-danger errors-fecha_nacimiento" /> --}}
                </div>

                <!-- Teléfono -->
                <div class="col-md-3">
                    <x-input-label for="telefono" :value="__('Teléfono')" class="form-label" />
                    <x-text-input id="telefono" class="form-control" type="tel" name="telefono" :value="old('telefono')"
                        autofocus />
                    {{-- <x-input-error :messages="$errors->get('telefono')" class=" badge text-danger errors-telefono" /> --}}
                    <small class="text-muted">
                        Formato: +34 123456789 o 123456789.
                    </small>
                </div>

                <div class="col-12" style="text-align: center;">
                    <button type="submit" id="btn-enviar" class="btn-2" style="width: 200px;">REGISTRARSE</button>
                </div>
            </form>
        </div>
    </div>
@endsection

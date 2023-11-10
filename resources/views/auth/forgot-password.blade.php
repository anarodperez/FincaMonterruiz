@extends('layouts.guest')

@section('title')
    Recuperación contraseña
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
@endsection

@section('content')
    <div class="wrapper">
      <div class="signup-form" style="background: white">
       <h3>Reestablece la contraseña</h3>
    <div class="mb-4 text-sm text-gray-600">
       {{ __('¿Has olvidado tu contraseña? ¿No te preocupes!') }} <br>
{{ __('Proporciona tu correo electrónico y recibirás un enlace para restablecerla.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
          <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="input" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <span id="emailError" style="color: red; display: none;"></span>
        </div>

        <button type="submit" class="btn-2" onclick="return validateForm()">
            {{ __('Enviar') }}
        </button>

    </form>
    </div>
</div>

<script>
    function validateForm() {
        var email = document.getElementById('email').value;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var emailError = document.getElementById('emailError');

        if (!emailRegex.test(email)) {
            emailError.innerText = 'Por favor, introduce una dirección de correo electrónico válida.';
            emailError.style.display = 'block';
            return false; // Evita que el formulario se envíe si la validación falla
        }

        emailError.style.display = 'none';
        return true; // Permite el envío del formulario si la validación es exitosa
    }
</script>
@endsection



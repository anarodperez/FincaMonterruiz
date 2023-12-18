@extends('layouts.guest')

@section('title', 'Editar perfil')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script type="text/javascript"  src="{{ asset('js/profile.js') }}" defer></script>

@endsection

@section('content')

    <div class="container my-5">
        <div class="form-section">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="form-section">
            @include('profile.partials.update-password-form')
        </div>

        <div class="form-section">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

@endsection

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información del perfil') }}
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            {{ __('Actualiza la información de perfil.') }}
        </p>

        @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 3000)"
            class="alert alert-success" role="alert">
            {{ __('Tu perfil ha sido actualizado correctamente.') }}</p>
    @endif
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" id="profile-form">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" name="nombre" type="text" class="mt-2 block w-full"
                style="margin-bottom: 16px !important;" :value="old('nombre', $user->nombre)" autofocus autocomplete="nombre" />
            <x-input-error class="mt-3" :messages="$errors->get('nombre')" />
        </div>
        <div class="mb-3">
            <x-input-label for="apellido1" :value="__('Primer apellido')" />
            <x-text-input id="apellido1" name="apellido1" type="text" class="mt-2 block w-full"
                style="margin-bottom: 16px !important;" :value="old('apellido1', $user->apellido1)" autofocus autocomplete="apellido1" />
            <x-input-error class="mt-3" :messages="$errors->get('apellido1')" />
        </div>
        <div class="mb-3">
            <x-input-label for="apellido2" :value="__('Segundo apellido')" />
            <x-text-input id="apellido2" name="apellido2" type="text" class="mt-2 block w-full"
                style="margin-bottom: 16px !important;" :value="old('apellido2', $user->apellido2)" autofocus autocomplete="apellido2" />
            <x-input-error class="mt-3" :messages="$errors->get('apellido2')" />
        </div>
        <div class="mb-3">
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" name="telefono" type="text" class="mt-2 block w-full"
                style="margin-bottom: 16px !important;" :value="old('telefono', $user->telefono)" autofocus autocomplete="telefono" />
            <x-input-error class="mt-3" :messages="$errors->get('telefono')" />
        </div>
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full"
                style="margin-bottom: 16px !important;" :value="old('email', $user->email)" autocomplete="username" />
            <x-input-error class="mt-3" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-3 text-gray-800">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Haz clic aquí para volver a enviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 font-medium text-sm text-green-600">
                            {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>
        </div>
    </form>
</section>


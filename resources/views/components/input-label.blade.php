@props(['value'])

<label style="padding-bottom: 10px;"{{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>

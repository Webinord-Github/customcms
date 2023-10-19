@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full border rounded py-2 text-gray-700 focus:outline-none items-center']) !!}>

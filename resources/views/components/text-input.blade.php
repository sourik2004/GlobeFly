@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'glass-input rounded-md shadow-sm py-2 px-3']) }}>

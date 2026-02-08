@props(['type' => 'success', 'message'])

@php
    $colorClass = $type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
    $icon = $type === 'success' ? 'fa-check-circle' : 'fa-circle-exclamation';
@endphp

<div class="{{ $colorClass }} border-l-4 p-4 rounded shadow-sm flex items-center mb-4 transition-all duration-300" role="alert">
    <i class="fa-solid {{ $icon }} mr-3 text-lg"></i>
    <div>
        <p class="font-bold capitalize">{{ $type }}!</p>
        <p class="text-sm">{{ $message }}</p>
    </div>
</div>
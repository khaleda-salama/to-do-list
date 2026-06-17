@use('App\Enums\IdeaStatus')

@props(['status' =>  IdeaStatus::PENDING->value])

@php

    $classes = 'inline-block rounded-full border px-2 py-1 text-xs font-medium';

    $classes .= match ($status) {
        IdeaStatus::PENDING->value => ' bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
        IdeaStatus::IN_PROGRESS->value => ' bg-blue-500/10 text-blue-500 border-blue-500/20',
        IdeaStatus::COMPLETED->value => ' bg-primary/10 text-primary border-primary/20',
        default => ' bg-gray-500/10 text-gray-500 border-gray-500/20',
    };

@endphp


<span {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</span>

@props([
    'label',
    'value',
    'unit' => 'C',
    'tone' => 'cyan',
    'sensor' => 'DS18B20',
    'change' => '+0.4',
    'sensorKey' => null,
])

@php
    $tones = [
        'red' => ['text' => 'text-[#006c4e] dark:text-[#cdfef1]', 'soft' => 'bg-[#e6fef8] text-[#03634a] dark:bg-[#006c4e]/20 dark:text-[#cdfef1]', 'icon' => 'thermostat', 'color' => '#006c4e', 'animate' => 'animate-float-slow'],
        'blue' => ['text' => 'text-[#05c793] dark:text-[#9cfce3]', 'soft' => 'bg-[#e6fef8] text-[#03634a] dark:bg-[#05c793]/20 dark:text-[#9cfce3]', 'icon' => 'ac_unit', 'color' => '#05c793', 'animate' => 'animate-spin-slow'],
        'orange' => ['text' => 'text-[#ffb300] dark:text-[#ffd166]', 'soft' => 'bg-[#fff7e5] text-[#996b00] dark:bg-[#ffb300]/22 dark:text-[#ffd166]', 'icon' => 'waves', 'color' => '#ffb300', 'animate' => 'animate-wave-slow'],
        'cyan' => ['text' => 'text-[#006c4e] dark:text-[#cdfef1]', 'soft' => 'bg-[#e6fef8] text-[#004d36] dark:bg-[#006c4e]/20 dark:text-[#cdfef1]', 'icon' => 'sensors', 'color' => '#006c4e', 'animate' => 'animate-pulse'],
    ];
    $toneData = $tones[$tone] ?? $tones['cyan'];

    $svgs = [
        'thermostat' => '<svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5a3 3 0 016 0v7.697a5 5 0 11-6 0V4.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5v6" /></svg>',
        'ac_unit' => '<svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18M12 9l-3-3M12 9l3-3M12 15l-3 3M12 15l3 3M9 12L6 9M9 12l-3 3M15 12l3-3M15 12l3 3" /></svg>',
        'waves' => '<svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10c2.5-3 5.5-3 8 0s5.5 3 8 0M3 14c2.5-3 5.5-3 8 0s5.5 3 8 0" /></svg>',
        'sensors' => '<svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" /></svg>',
    ];
@endphp

<article class="metric-card group relative overflow-hidden rounded-2xl p-6 transition hover:shadow-md" @if($sensorKey) data-sensor-card="{{ $sensorKey }}" @endif>
    <div class="absolute right-4 top-4 opacity-55 transition-all duration-500 group-hover:scale-110 group-hover:opacity-95">
        <span class="inline-flex items-center justify-center text-7xl {{ $toneData['text'] }} {{ $toneData['animate'] ?? '' }}">{!! $svgs[$toneData['icon']] !!}</span>
    </div>

    <div class="relative flex items-start justify-between gap-4">
        <div>
            <p class="flex items-center gap-2 font-mono text-xs font-bold uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">
                <span class="h-2 w-2 rounded-full" style="background: {{ $toneData['color'] }}"></span>
                {{ $label }}
            </p>
            <div class="mt-3 flex items-end gap-1">
                <span class="font-mono text-4xl font-bold tracking-tight {{ $toneData['text'] }}" data-temp-value data-base="{{ $value }}" @if($sensorKey) data-sensor-value="{{ $sensorKey }}" @endif>{{ $value }}</span>
                <span class="pb-1 text-2xl font-bold text-[#191c1e] dark:text-[#e6fef8]">&deg;{{ $unit }}</span>
            </div>
        </div>
    </div>

    <div class="relative mt-6 h-2.5 w-full overflow-hidden rounded-full bg-[#e6fef8] dark:bg-[#e6fef8]">
        <div class="h-full rounded-full transition-all duration-1000" @if($sensorKey) data-sensor-bar="{{ $sensorKey }}" @endif style="width: {{ min(100, max(8, $value)) }}%; background: {{ $toneData['color'] }}"></div>
    </div>

    <div class="relative mt-5 flex items-center justify-between gap-3">
        <span class="rounded-full px-2.5 py-1 font-mono text-xs font-bold {{ $toneData['soft'] }}">{{ $sensor }}</span>
        <span class="text-xs font-bold text-[#191c1e] dark:text-[#e6fef8]" @if($sensorKey) data-sensor-drift="{{ $sensorKey }}" @endif>Drift {{ $change }}&deg;C</span>
    </div>
</article>

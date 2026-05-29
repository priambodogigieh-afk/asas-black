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
        'red' => ['text' => 'text-[#ac2bd4] dark:text-[#cd80e5]', 'soft' => 'bg-[#f7eafb] text-[#671a7f] dark:bg-[#ac2bd4]/20 dark:text-[#cd80e5]', 'icon' => 'thermostat', 'color' => '#ac2bd4'],
        'blue' => ['text' => 'text-[#30cfb7] dark:text-[#83e2d4]', 'soft' => 'bg-[#d6f5f1] text-[#1d7c6e] dark:bg-[#30cfb7]/20 dark:text-[#83e2d4]', 'icon' => 'ac_unit', 'color' => '#30cfb7'],
        'orange' => ['text' => 'text-[#8a23a9] dark:text-[#cd80e5]', 'soft' => 'bg-[#eed5f6] text-[#671a7f] dark:bg-[#8a23a9]/22 dark:text-[#cd80e5]', 'icon' => 'waves', 'color' => '#8a23a9'],
        'cyan' => ['text' => 'text-[#30cfb7] dark:text-[#83e2d4]', 'soft' => 'bg-[#d6f5f1] text-[#1d7c6e] dark:bg-[#30cfb7]/20 dark:text-[#83e2d4]', 'icon' => 'sensors', 'color' => '#30cfb7'],
    ];
    $toneData = $tones[$tone] ?? $tones['cyan'];
@endphp

<article class="metric-card group relative overflow-hidden rounded-2xl p-6 transition hover:shadow-md" @if($sensorKey) data-sensor-card="{{ $sensorKey }}" @endif>
    <div class="absolute right-4 top-4 opacity-10">
        <span class="material-symbols-outlined text-7xl {{ $toneData['text'] }}">{{ $toneData['icon'] }}</span>
    </div>

    <div class="relative flex items-start justify-between gap-4">
        <div>
            <p class="flex items-center gap-2 font-['Geist'] text-xs font-bold uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">
                <span class="h-2 w-2 rounded-full" style="background: {{ $toneData['color'] }}"></span>
                {{ $label }}
            </p>
            <div class="mt-3 flex items-end gap-1">
                <span class="font-['Geist'] text-4xl font-bold tracking-tight {{ $toneData['text'] }}" data-temp-value data-base="{{ $value }}" @if($sensorKey) data-sensor-value="{{ $sensorKey }}" @endif>{{ $value }}</span>
                <span class="pb-1 text-2xl font-bold text-[#135349] dark:text-[#d6f5f1]">&deg;{{ $unit }}</span>
            </div>
        </div>
    </div>

    <div class="relative mt-6 h-2 w-full overflow-hidden rounded-full bg-[#d6f5f1]/20 dark:bg-[#d6f5f1]/20">
        <div class="h-full rounded-full transition-all duration-1000" @if($sensorKey) data-sensor-bar="{{ $sensorKey }}" @endif style="width: {{ min(100, max(8, $value)) }}%; background: {{ $toneData['color'] }}"></div>
    </div>

    <div class="relative mt-5 flex items-center justify-between gap-3">
        <span class="rounded-full px-2.5 py-1 font-['Geist'] text-xs font-bold {{ $toneData['soft'] }}">{{ $sensor }}</span>
        <span class="text-xs font-bold text-[#135349] dark:text-[#d6f5f1]" @if($sensorKey) data-sensor-drift="{{ $sensorKey }}" @endif>Drift {{ $change }}&deg;C</span>
    </div>
</article>

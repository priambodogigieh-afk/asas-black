@props(['title' => 'Dashboard', 'subtitle' => '', 'role' => 'Guru'])

@php
    $user = auth()->user();
    $accent = $role === 'Siswa' ? 'text-[#ac2bd4] dark:text-[#cd80e5]' : 'text-[#30cfb7] dark:text-[#83e2d4]';
@endphp

<header class="sticky top-0 z-30 border-b border-[#acece2]/50 bg-[#d6f5f1]/80 px-4 py-3 shadow-sm backdrop-blur-xl dark:border-[#27a592]/30 dark:bg-[#071d1a]/72 sm:px-6 lg:px-8">
    <div class="mx-auto flex max-w-[1540px] flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="font-['Geist'] text-xs font-bold uppercase tracking-[0.22em] {{ $accent }}">{{ $role }} Physics Portal</p>
            <h1 class="mt-1 font-['Inter'] text-2xl font-black text-[#071d1a] dark:text-[#eafaf8]">{{ $title }}</h1>
            @if ($subtitle)
                <p class="mt-1 max-w-3xl text-sm text-[#135349] dark:text-[#d6f5f1]">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($user)
                <span class="hidden max-w-[220px] truncate rounded-full bg-[#eafaf8] px-3 py-2 text-xs font-black text-[#135349] shadow-sm dark:bg-[#0a2925] dark:text-[#d6f5f1] sm:inline-block">
                    {{ $user->name }}
                </span>
            @endif
        </div>
    </div>
</header>

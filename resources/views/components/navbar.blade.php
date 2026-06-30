@props(['title' => 'Dashboard', 'subtitle' => '', 'role' => 'Guru'])

@php
    $user = auth()->user();
    $accent = $role === 'Siswa' ? 'text-[#006c4e] dark:text-[#05c793]' : 'text-[#006c4e] dark:text-[#cdfef1]';
@endphp

<header class="sticky top-0 z-30 border-b border-[#cdfef1]/50 bg-[#e6fef8]/80 px-4 py-3 shadow-sm backdrop-blur-xl dark:border-[#03634a]/30 dark:bg-[#013225]/72 sm:px-6 lg:px-8">
    <div class="mx-auto flex max-w-[1540px] flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div class="min-w-0 flex items-center gap-3">
            <!-- Mobile Menu Toggle Button (Hamburger) -->
            <button type="button" data-sidebar-show class="lg:hidden grid h-10 w-10 shrink-0 place-items-center rounded-xl border border-[#cdfef1] bg-white text-[#006c4e] shadow-sm hover:bg-[#e6fef8] dark:border-[#03634a]/40 dark:bg-[#013225] dark:text-white" aria-label="Tampilkan sidebar" title="Tampilkan sidebar">
                <svg class="h-6 w-6 text-emerald-800 dark:text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="min-w-0">
                <p class="font-mono text-xs font-bold uppercase tracking-[0.22em] {{ $accent }}">Portal Fisika {{ $role }}</p>
                <h1 class="mt-1 break-words font-sans text-xl font-black text-[#013225] dark:text-[#ffffff] sm:text-[2rem] leading-none">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="mt-1 max-w-3xl text-sm leading-6 text-[#191c1e] dark:text-[#e6fef8]">{{ $subtitle }}</p>
                @endif
            </div>
        </div>

        @if ($user && $user->role !== 'siswa')
            <div class="flex flex-wrap items-center gap-2 md:justify-end">
                <span class="max-w-[220px] truncate rounded-full bg-[#ffffff] px-3 py-2 text-xs font-black text-[#191c1e] shadow-sm dark:bg-[#013225] dark:text-[#e6fef8] sm:inline-block">
                    {{ $user->name }}
                </span>
            </div>
        @endif
    </div>
</header>

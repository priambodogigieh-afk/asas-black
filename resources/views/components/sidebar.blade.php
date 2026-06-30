@props(['role' => 'Guru', 'items' => []])

@php
    $homeRoute = $role === 'Siswa' ? 'student.praktikum' : 'teacher.dashboard';
    $user = auth()->user();
    $displayName = $user?->name ?? ($role === 'Siswa' ? 'Siswa' : 'Guru');
    $displayInitial = collect(explode(' ', $displayName))
        ->filter()
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');
    $accountMeta = $role === 'Siswa'
        ? collect([$user?->kelas, $user?->nis])->filter()->implode(' / ')
        : ($user?->email ?? 'Akun guru');
    $isStudent = $role === 'Siswa';
    $brandText = $isStudent ? 'text-[#006c4e] dark:text-[#05c793]' : 'text-[#006c4e] dark:text-[#cdfef1]';
    $brandBg = $isStudent ? 'bg-[#006c4e] dark:bg-[#05c793] dark:text-[#013225]' : 'bg-[#006c4e] dark:bg-[#cdfef1] dark:text-[#013225]';
    $activeClass = $isStudent ? 'bg-[#006c4e] text-white shadow-sm dark:bg-[#05c793] dark:text-[#013225]' : 'bg-[#006c4e] text-white shadow-sm dark:bg-[#cdfef1] dark:text-[#013225]';

    $svgs = [
        'dashboard' => '<svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" /></svg>',
        'sensors' => '<svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" /></svg>',
        'group' => '<svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>',
        'rate_review' => '<svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>',
        'logout' => '<svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>',
        'calculate' => '<svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 11h.01M12 7h.01M15 11h.01M12 14h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>',
        'history' => '<svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
    ];
@endphp

<aside data-sidebar class="fixed left-0 top-0 z-40 flex h-screen w-64 -translate-x-full shrink-0 flex-col border-r border-[#cdfef1]/60 bg-[#ffffff]/92 p-2 shadow-md backdrop-blur-xl transition-[width,transform] duration-300 dark:border-[#03634a]/30 dark:bg-[#013225]/92 lg:translate-x-0 lg:flex">
    <div class="brand-container flex items-start justify-between gap-3 px-4 py-6">
        <a href="{{ route($homeRoute) }}" class="flex min-w-0 flex-col gap-1 hide-on-collapsed">
            <span class="font-sans text-2xl font-black tracking-tight {{ $brandText }}">Asas Black</span>
            <span class="font-mono text-xs font-bold uppercase tracking-[0.18em] text-[#191c1e] dark:text-[#e6fef8]">Lab Termodinamika</span>
        </a>
        <button type="button" data-sidebar-hide class="grid h-9 w-9 shrink-0 place-items-center rounded-lg border border-[#cdfef1] bg-white text-[#006c4e] transition hover:bg-[#e6fef8] dark:border-[#03634a]/40 dark:bg-[#013225] dark:text-white" aria-label="Tutup/Lipat sidebar" title="Tutup/Lipat sidebar">
            <svg class="h-5 w-5 text-emerald-800 dark:text-emerald-300 transition-transform duration-300" data-sidebar-toggle-icon fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    </div>

    @if (!$isStudent)
    <div class="mx-2 rounded-lg border border-[#cdfef1]/70 bg-[#e6fef8]/80 px-3 py-3 text-xs text-[#191c1e] backdrop-blur dark:border-[#03634a]/30 dark:bg-[#013225]/45 dark:text-[#ffffff] hide-on-collapsed">
        <div class="flex items-center justify-between">
            <span class="font-mono font-bold uppercase tracking-[0.16em]">Mode {{ $role }}</span>
            <span class="h-2 w-2 rounded-full bg-[#006c4e] shadow-[0_0_14px_rgba(60,132,195,.75)]"></span>
        </div>
        <p class="mt-1">{{ $user?->email ?? 'Belum login' }}</p>
    </div>
    @endif

    <nav class="mt-5 flex flex-col gap-1 px-2 overflow-y-auto pr-1">
        @foreach ($items as $item)
            @php
                $active = request()->routeIs($item['route']);
                $isLogout = strtolower($item['label']) === 'logout' || strtolower($item['label']) === 'keluar' || $item['icon'] === 'logout';
            @endphp

            @if ($isLogout)
                <form method="POST" action="{{ route('logout') }}" data-logout-form>
                    @csrf
                    <button
                        type="submit"
                        class="group flex w-full items-center gap-3 rounded-lg px-4 py-3 text-left text-sm font-bold text-[#191c1e] transition duration-200 hover:scale-[1.02] hover:bg-[#e6fef8] dark:text-[#e6fef8] dark:hover:bg-[#013225]"
                        title="{{ $item['label'] }}"
                    >
                        <span class="inline-flex shrink-0 items-center justify-center text-[22px]">{!! $svgs[$item['icon']] ?? $item['icon'] !!}</span>
                        <span class="font-mono text-xs uppercase tracking-[0.08em] hide-on-collapsed">{{ $item['label'] }}</span>
                    </button>
                </form>
            @else
                <a
                    href="{{ route($item['route']) }}"
                    class="group flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-bold transition duration-200 {{ $active ? $activeClass : 'text-[#191c1e] hover:scale-[1.02] hover:bg-[#e6fef8] dark:text-[#e6fef8] dark:hover:bg-[#013225]' }}"
                    title="{{ $item['label'] }}"
                >
                    <span class="inline-flex shrink-0 items-center justify-center text-[22px]">{!! $svgs[$item['icon']] ?? $item['icon'] !!}</span>
                    <span class="font-mono text-xs uppercase tracking-[0.08em] hide-on-collapsed">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <div class="profile-container absolute inset-x-2 bottom-4 rounded-xl border border-[#cdfef1]/70 bg-[#e6fef8]/82 p-3 dark:border-[#03634a]/30 dark:bg-[#013225]/50 transition-all duration-300">
        <div class="flex items-center gap-3 justify-center lg:justify-start">
            <div class="grid h-10 w-10 shrink-0 place-items-center rounded-full text-xs font-black text-white {{ $brandBg }}">{{ $displayInitial ?: ($role === 'Siswa' ? 'SW' : 'GR') }}</div>
            <div class="min-w-0 hide-on-collapsed">
                <p class="truncate text-sm font-black text-[#013225] dark:text-[#ffffff]">{{ $displayName }}</p>
                <p class="truncate text-xs text-[#191c1e] dark:text-[#e6fef8]">{{ $accountMeta ?: ($user?->email ?? 'Akun aktif') }}</p>
            </div>
        </div>
    </div>
</aside>


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
    $brandText = $isStudent ? 'text-[#ac2bd4] dark:text-[#cd80e5]' : 'text-[#30cfb7] dark:text-[#83e2d4]';
    $brandBg = $isStudent ? 'bg-[#ac2bd4] dark:bg-[#cd80e5] dark:text-[#18061e]' : 'bg-[#30cfb7] dark:bg-[#83e2d4] dark:text-[#071d1a]';
    $activeClass = $isStudent ? 'bg-[#ac2bd4] text-white shadow-sm dark:bg-[#cd80e5] dark:text-[#18061e]' : 'bg-[#30cfb7] text-white shadow-sm dark:bg-[#83e2d4] dark:text-[#071d1a]';
@endphp

<aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 shrink-0 flex-col border-r border-[#acece2]/60 bg-[#eafaf8]/92 p-2 shadow-md backdrop-blur-xl dark:border-[#27a592]/30 dark:bg-[#071d1a]/92 lg:flex">
    <a href="{{ route($homeRoute) }}" class="flex flex-col gap-1 px-4 py-6">
        <span class="font-['Inter'] text-2xl font-black tracking-tight {{ $brandText }}">Asas Black</span>
        <span class="font-['Geist'] text-xs font-bold uppercase tracking-[0.18em] text-[#135349] dark:text-[#d6f5f1]">Thermodynamics Lab</span>
    </a>

    <div class="mx-2 rounded-lg border border-[#acece2]/70 bg-[#d6f5f1]/80 px-3 py-3 text-xs text-[#135349] backdrop-blur dark:border-[#27a592]/30 dark:bg-[#0a2925]/45 dark:text-[#eafaf8]">
        <div class="flex items-center justify-between">
            <span class="font-['Geist'] font-bold uppercase tracking-[0.16em]">Mode {{ $role }}</span>
            <span class="h-2 w-2 rounded-full bg-[#30cfb7] shadow-[0_0_14px_rgba(48,207,183,.75)]"></span>
        </div>
        <p class="mt-1">{{ $user?->email ?? 'Belum login' }}</p>
    </div>

    <nav class="mt-5 flex flex-col gap-1 px-2">
        @foreach ($items as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a
                href="{{ route($item['route']) }}"
                class="group flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-bold transition duration-200 {{ $active ? $activeClass : 'text-[#135349] hover:scale-[1.02] hover:bg-[#d6f5f1] dark:text-[#d6f5f1] dark:hover:bg-[#0a2925]' }}"
            >
                <span class="material-symbols-outlined text-[22px]">
                    {!! $item['icon'] !!}
                </span>
                <span class="font-['Geist'] text-xs uppercase tracking-[0.08em]">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="absolute inset-x-2 bottom-4 rounded-xl border border-[#acece2]/70 bg-[#d6f5f1]/82 p-3 dark:border-[#27a592]/30 dark:bg-[#0a2925]/50">
        <div class="flex items-center gap-3">
            <div class="grid h-10 w-10 place-items-center rounded-full text-xs font-black text-white {{ $brandBg }}">{{ $displayInitial ?: ($role === 'Siswa' ? 'SW' : 'GR') }}</div>
            <div class="min-w-0">
                <p class="truncate text-sm font-black text-[#071d1a] dark:text-[#eafaf8]">{{ $displayName }}</p>
                <p class="truncate text-xs text-[#135349] dark:text-[#d6f5f1]">{{ $accountMeta ?: ($user?->email ?? 'Akun aktif') }}</p>
            </div>
        </div>
    </div>
</aside>

<div class="border-b border-[#acece2]/70 bg-[#d6f5f1]/95 px-4 py-3 backdrop-blur-xl dark:border-[#27a592]/30 dark:bg-[#071d1a]/90 lg:hidden">
    <div class="flex items-center justify-between">
        <a href="{{ route($homeRoute) }}" class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-full text-xs font-black text-white {{ $brandBg }}">AB</span>
            <span class="text-sm font-black {{ $brandText }}">Asas Black Lab</span>
        </a>
        <select class="rounded-lg border border-[#acece2] bg-[#eafaf8] px-3 py-2 text-sm dark:border-[#27a592]/40 dark:bg-[#0a2925]" onchange="if (this.value) window.location.href = this.value">
            @foreach ($items as $item)
                <option value="{{ route($item['route']) }}" @selected(request()->routeIs($item['route']))>{{ $item['label'] }}</option>
            @endforeach
        </select>
    </div>
</div>

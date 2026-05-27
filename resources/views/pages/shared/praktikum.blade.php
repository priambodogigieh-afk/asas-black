<x-layouts.dashboard
    title="Praktikum Asas Black"
    subtitle="Input massa air, hitung kalor, dan simpan riwayat praktikum."
    :role="$role"
    :items="$items"
>
    <div class="space-y-6" data-page="student-dashboard">
        @if ($role === 'Siswa' && auth()->user())
            <section class="metric-card rounded-2xl p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="grid h-14 w-14 place-items-center rounded-full bg-[#ac2bd4] text-sm font-black text-white">
                            {{ collect(explode(' ', auth()->user()->name))->filter()->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->implode('') }}
                        </div>
                        <div>
                            <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#30cfb7] dark:text-[#83e2d4]">Akun Mahasiswa/Siswa</p>
                            <h2 class="mt-1 font-['Inter'] text-xl font-black text-[#071d1a] dark:text-[#eafaf8]">{{ auth()->user()->name }}</h2>
                            <p class="mt-1 text-sm font-semibold text-[#135349] dark:text-[#d6f5f1]">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="rounded-xl bg-[#071d1a] px-4 py-3 text-[#eafaf8]">
                            <p class="font-['Geist'] text-[10px] font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Kelas</p>
                            <p class="mt-1 font-black">{{ auth()->user()->kelas ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl bg-[#071d1a] px-4 py-3 text-[#eafaf8]">
                            <p class="font-['Geist'] text-[10px] font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">NIS</p>
                            <p class="mt-1 font-black">{{ auth()->user()->nis ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl bg-[#071d1a] px-4 py-3 text-[#eafaf8]">
                            <p class="font-['Geist'] text-[10px] font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Jurusan</p>
                            <p class="mt-1 font-black">{{ auth()->user()->jurusan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <x-temperature-card label="T1: Air Panas" value="70" tone="red" />
            <x-temperature-card label="T2: Air Dingin" value="28" tone="blue" />
            <x-temperature-card label="Tc: Air Campuran" value="45" tone="orange" />
        </section>

        <section class="grid gap-6 xl:grid-cols-[.9fr_1.1fr]">
            <article class="metric-card rounded-2xl p-6">
                <h2 class="font-['Inter'] text-2xl font-black text-[#071d1a] dark:text-[#eafaf8]">Input Data Percobaan</h2>
                @if (session('success'))
                    <div class="mt-5 rounded-lg bg-[#d6f5f1] px-4 py-3 text-sm font-bold text-[#1d7c6e]">
                        {{ session('success') }}
                    </div>
                @endif

                <form
                    class="mt-6 space-y-4"
                    data-asas-form
                    @if ($role === 'Siswa')
                        data-save-url="{{ route('student.praktikum.history.store') }}"
                    @endif
                >
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="font-['Geist'] text-xs font-black uppercase tracking-[0.10em] text-[#135349] dark:text-[#d6f5f1]">Massa Air Panas (kg)</span>
                            <input name="hotMass" type="number" min="0.01" step="0.01" value="0.25" inputmode="decimal" required class="mt-2 w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-4 py-3 font-['Geist'] text-base font-bold outline-none focus:border-[#ac2bd4] focus:ring-4 focus:ring-[#f7eafb] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                        </label>
                        <label class="block">
                            <span class="font-['Geist'] text-xs font-black uppercase tracking-[0.10em] text-[#135349] dark:text-[#d6f5f1]">Massa Air Dingin (kg)</span>
                            <input name="coldMass" type="number" min="0.01" step="0.01" value="0.35" inputmode="decimal" required class="mt-2 w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-4 py-3 font-['Geist'] text-base font-bold outline-none focus:border-[#ac2bd4] focus:ring-4 focus:ring-[#f7eafb] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                        </label>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                        <button type="submit" class="rounded-xl bg-[#ac2bd4] px-5 py-4 font-black text-white shadow-md transition active:scale-95">
                            Hitung Asas Black
                        </button>
                        <button type="button" data-reset-asas class="rounded-xl border border-[#acece2] bg-[#eafaf8] px-5 py-4 font-black text-[#071d1a] transition hover:bg-[#eafaf8] dark:border-[#27a592]/40 dark:bg-[#0a2925] dark:text-[#eafaf8]">
                            Reset
                        </button>
                    </div>
                </form>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-xl bg-[#f7eafb] p-4">
                        <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.10em] text-[#671a7f]">Qlepas</p>
                        <p class="mt-1 font-['Geist'] text-2xl font-bold text-[#ac2bd4]" data-q-release>0 J</p>
                    </div>
                    <div class="rounded-xl bg-[#d6f5f1] p-4">
                        <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.10em] text-[#1d7c6e]">Qterima</p>
                        <p class="mt-1 font-['Geist'] text-2xl font-bold text-[#30cfb7]" data-q-accept>0 J</p>
                    </div>
                    <div class="rounded-xl bg-[#eafaf8] p-4 dark:bg-[#0a2925]">
                        <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.10em] text-[#135349] dark:text-[#d6f5f1]">Delta Q</p>
                        <p class="mt-1 font-['Geist'] text-2xl font-bold" data-delta-q>0 J</p>
                    </div>
                    <div class="rounded-xl bg-[#eafaf8] p-4 dark:bg-[#0a2925]">
                        <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.10em] text-[#135349] dark:text-[#d6f5f1]">Error Persen</p>
                        <p class="mt-1 font-['Geist'] text-2xl font-bold" data-error-percent>0%</p>
                    </div>
                </div>
                <div class="mt-4 inline-flex items-center gap-3 rounded-full border border-[#acece2] bg-[#d6f5f1] px-5 py-3 font-black text-[#1d7c6e]" data-asas-status-pill>
                    <span class="material-symbols-outlined text-[#30cfb7]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    <span data-asas-status>Sesuai Asas Black</span>
                </div>
                <p class="mt-4 rounded-lg bg-[#eafaf8] px-4 py-3 text-xs font-bold text-[#135349] dark:bg-[#0a2925] dark:text-[#d6f5f1]" data-asas-note>
                    Hasil dihitung otomatis berdasarkan massa air panas dan massa air dingin.
                </p>
                @if ($role === 'Siswa')
                    <p class="mt-3 rounded-lg bg-[#d6f5f1] px-4 py-3 text-xs font-bold text-[#1d7c6e]" data-save-status>
                        Tekan Hitung Asas Black untuk menyimpan riwayat praktikum
                    </p>
                @endif
            </article>

            <section class="space-y-6">
                <article class="metric-card rounded-2xl p-6">
                    <h2 class="font-['Inter'] text-2xl font-black text-[#071d1a] dark:text-[#eafaf8]">Grafik Percobaan</h2>
                    <div class="chart-shell mt-5 h-[340px] rounded-xl border border-[#acece2]/60 bg-[#d6f5f1]/80 p-4 dark:border-[#27a592]/30 dark:bg-[#0a2925]/45">
                        <canvas id="studentRealtimeChart"></canvas>
                    </div>
                </article>

            </section>
        </section>
    </div>
</x-layouts.dashboard>

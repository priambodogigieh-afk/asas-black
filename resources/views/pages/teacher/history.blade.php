<x-layouts.dashboard
    title="Penilaian Praktikum"
    subtitle="Pilih kategori kelas, lalu beri nilai untuk hasil praktikum mahasiswa/siswa pada kelas tersebut."
    role="Guru"
    :items="$items"
>
    <div class="space-y-6">
        @php
            $activeSummary = collect($classSummaries)->firstWhere('name', $selectedClass);
            $pendingCount = $activeSummary['pending_count'] ?? $histories->whereNull('nilai')->count();
            $gradedCount = $activeSummary['graded_count'] ?? $histories->whereNotNull('nilai')->count();
        @endphp

        <section class="grid gap-4 md:grid-cols-4">
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Kelas Aktif</p>
                <p class="mt-3 font-['Geist'] text-3xl font-bold">{{ $selectedClass ?: '-' }}</p>
                <p class="mt-2 text-xs font-bold text-[#30cfb7] dark:text-[#83e2d4]">Kategori penilaian</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Data Kelas</p>
                <p class="mt-3 font-['Geist'] text-4xl font-bold">{{ $histories->count() }}</p>
                <p class="mt-2 text-xs font-bold text-[#8a23a9] dark:text-[#cd80e5]">Riwayat praktikum</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Sudah Dinilai</p>
                <p class="mt-3 font-['Geist'] text-4xl font-bold text-[#30cfb7]">{{ $gradedCount }}</p>
                <p class="mt-2 text-xs font-bold text-[#30cfb7]">Nilai tersimpan</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Belum Dinilai</p>
                <p class="mt-3 font-['Geist'] text-4xl font-bold text-[#ac2bd4]">{{ $pendingCount }}</p>
                <p class="mt-2 text-xs font-bold text-[#ac2bd4] dark:text-[#cd80e5]">Menunggu penilaian</p>
            </article>
        </section>

        <section class="metric-card rounded-2xl p-5">
            <div class="flex flex-col justify-between gap-3 md:flex-row md:items-center">
                <div>
                    <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#30cfb7] dark:text-[#83e2d4]">Kategori Per Kelas</p>
                    <h2 class="mt-1 font-['Inter'] text-xl font-black">Pilih kelas untuk penilaian</h2>
                </div>
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Rata-rata Error</p>
                <p class="font-['Geist'] text-lg font-bold">{{ $histories->count() ? number_format($histories->avg('error_persen'), 2) : '0.00' }}%</p>
            </div>

            <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                @forelse ($classSummaries as $summary)
                    <a href="{{ route('teacher.history', ['kelas' => $summary['name']]) }}"
                        class="rounded-xl border p-4 transition {{ $selectedClass === $summary['name'] ? 'border-[#ac2bd4] bg-[#eafaf8] shadow-sm dark:border-[#cd80e5] dark:bg-[#0a2925]' : 'border-[#acece2] bg-[#d6f5f1]/80 hover:border-[#ac2bd4]/50 dark:border-[#27a592]/30 dark:bg-[#0a2925]/45' }}">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-['Inter'] text-lg font-black">{{ $summary['name'] }}</p>
                                <p class="mt-1 text-xs font-bold text-[#135349] dark:text-[#d6f5f1]">{{ $summary['students_count'] }} siswa</p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-xs font-black {{ $summary['pending_count'] > 0 ? 'bg-[#f7eafb] text-[#8a23a9]' : 'bg-[#d6f5f1] text-[#1d7c6e]' }}">
                                {{ $summary['pending_count'] }} pending
                            </span>
                        </div>
                        <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-lg bg-[#d6f5f1] p-2 dark:bg-[#071d1a]">
                                <p class="font-['Geist'] text-lg font-black">{{ $summary['histories_count'] }}</p>
                                <p class="text-[10px] font-black uppercase text-[#135349] dark:text-[#d6f5f1]">Data</p>
                            </div>
                            <div class="rounded-lg bg-[#d6f5f1] p-2 dark:bg-[#071d1a]">
                                <p class="font-['Geist'] text-lg font-black text-[#30cfb7]">{{ $summary['graded_count'] }}</p>
                                <p class="text-[10px] font-black uppercase text-[#135349] dark:text-[#d6f5f1]">Dinilai</p>
                            </div>
                            <div class="rounded-lg bg-[#d6f5f1] p-2 dark:bg-[#071d1a]">
                                <p class="font-['Geist'] text-lg font-black text-[#30cfb7]">{{ $summary['average_score'] ? number_format($summary['average_score'], 1) : '-' }}</p>
                                <p class="text-[10px] font-black uppercase text-[#135349] dark:text-[#d6f5f1]">Rerata</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="rounded-xl border border-[#acece2] bg-[#d6f5f1]/80 p-6 text-center font-bold text-[#135349] dark:border-[#27a592]/30 dark:bg-[#0a2925]/45 dark:text-[#d6f5f1]">
                        Belum ada data kelas pada akun siswa.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="metric-card overflow-hidden rounded-2xl">
            <div class="border-b border-[#acece2]/70 px-6 py-4 dark:border-[#27a592]/30">
                <h2 class="font-['Inter'] text-xl font-black">Penilaian Kelas {{ $selectedClass ?: '-' }}</h2>
                @if (session('success'))
                    <div class="mt-3 rounded-lg bg-[#d6f5f1] px-4 py-3 text-sm font-bold text-[#1d7c6e]">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mt-3 rounded-lg bg-[#f7eafb] px-4 py-3 text-sm font-bold text-[#8a23a9]">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1420px] text-left text-sm">
                    <thead class="bg-[#eafaf8] font-['Geist'] text-xs uppercase tracking-[0.08em] text-[#135349] dark:bg-[#0a2925]/70 dark:text-[#d6f5f1]">
                        <tr>
                            <th class="px-5 py-3">Waktu</th>
                            <th class="px-5 py-3">Nama</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Kelas</th>
                            <th class="px-5 py-3">NIS</th>
                            <th class="px-5 py-3">m1</th>
                            <th class="px-5 py-3">m2</th>
                            <th class="px-5 py-3">Qlepas</th>
                            <th class="px-5 py-3">Qterima</th>
                            <th class="px-5 py-3">Error</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Nilai</th>
                            <th class="px-5 py-3">CRUD Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#acece2]/50 dark:divide-[#27a592]/20">
                        @forelse ($histories as $history)
                            <tr class="transition hover:bg-[#eafaf8]/60 dark:hover:bg-[#0a2925]/60">
                                <td class="px-5 py-4 font-semibold">{{ $history->created_at->format('d M Y H:i') }}</td>
                                <td class="px-5 py-4 font-black">{{ $history->user->name }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $history->user->email }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $history->user->kelas ?? '-' }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $history->user->nis ?? '-' }}</td>
                                <td class="px-5 py-4 font-['Geist']">{{ $history->massa_panas }} kg</td>
                                <td class="px-5 py-4 font-['Geist']">{{ $history->massa_dingin }} kg</td>
                                <td class="px-5 py-4 font-['Geist'] text-[#ac2bd4]">{{ number_format($history->q_lepas, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-['Geist'] text-[#30cfb7]">{{ number_format($history->q_terima, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-['Geist']">{{ number_format($history->error_persen, 2) }}%</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-black {{ $history->status === 'Sesuai Asas Black' ? 'bg-[#d6f5f1] text-[#1d7c6e]' : 'bg-[#f7eafb] text-[#8a23a9]' }}">
                                        {{ $history->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    @if ($history->nilai !== null)
                                        <div class="font-['Geist'] text-2xl font-bold text-[#30cfb7]">{{ $history->nilai }}</div>
                                        <div class="mt-1 max-w-[220px] text-xs font-semibold text-[#135349] dark:text-[#d6f5f1]">{{ $history->catatan_nilai ?: 'Tanpa catatan' }}</div>
                                        @if ($history->dinilai_pada)
                                            <div class="mt-1 text-[10px] font-bold text-[#1d7c6e]">Dinilai {{ $history->dinilai_pada->format('d M Y H:i') }}</div>
                                        @endif
                                    @else
                                        <span class="rounded-full bg-[#eafaf8] px-2.5 py-1 text-xs font-black text-[#135349] dark:bg-[#0a2925] dark:text-[#d6f5f1]">Belum dinilai</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="grid min-w-[260px] gap-2">
                                        <form id="grade-form-{{ $history->id }}" method="POST" action="{{ route('teacher.history.grade', ['history' => $history, 'kelas' => $selectedClass]) }}" class="grid gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="grid grid-cols-[80px_1fr] gap-2">
                                            <input name="nilai" type="number" min="0" max="100" value="{{ old('nilai', $history->nilai ?? '') }}" placeholder="0-100" required class="rounded-lg border border-[#acece2] bg-[#eafaf8] px-3 py-2 font-['Geist'] text-sm font-bold outline-none focus:border-[#ac2bd4] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                                            <input name="catatan_nilai" type="text" value="{{ old('catatan_nilai', $history->catatan_nilai ?? '') }}" placeholder="Catatan opsional" class="rounded-lg border border-[#acece2] bg-[#eafaf8] px-3 py-2 text-sm font-semibold outline-none focus:border-[#ac2bd4] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                                        </div>
                                        </form>
                                        <div class="grid gap-2 {{ $history->nilai !== null ? 'grid-cols-2' : 'grid-cols-1' }}">
                                            <button type="submit" form="grade-form-{{ $history->id }}" class="rounded-lg bg-[#ac2bd4] px-3 py-2 text-xs font-black text-white">
                                                {{ $history->nilai === null ? 'Beri Nilai' : 'Update Nilai' }}
                                            </button>
                                            @if ($history->nilai !== null)
                                                <form method="POST" action="{{ route('teacher.history.grade.destroy', ['history' => $history, 'kelas' => $selectedClass]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-3 py-2 text-xs font-black text-[#8a23a9] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="px-5 py-10 text-center font-bold text-[#135349] dark:text-[#d6f5f1]">Belum ada riwayat praktikum tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.dashboard>

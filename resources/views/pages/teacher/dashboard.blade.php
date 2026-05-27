<x-layouts.dashboard
    title="Thermodynamics Monitoring"
    subtitle="Portal guru untuk memantau akun siswa dan riwayat praktikum yang tersimpan di MySQL."
    role="Guru"
    :items="$items"
>
    <div class="space-y-6" data-page="teacher-dashboard">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <span class="font-['Geist'] text-xs font-bold uppercase tracking-[0.22em] text-[#30cfb7] dark:text-[#83e2d4]">Physics Faculty Portal</span>
                <h2 class="mt-1 font-['Inter'] text-3xl font-black text-[#071d1a] dark:text-[#eafaf8]">Monitoring Praktikum Guru</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('teacher.history') }}" class="flex items-center gap-2 rounded-lg bg-[#ac2bd4] px-5 py-2 font-['Geist'] text-xs font-bold uppercase tracking-[0.08em] text-white shadow-md transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[18px]">rate_review</span>
                    Kelola Nilai
                </a>
            </div>
        </div>

        @php
            $stats = [
                ['icon' => 'group', 'label' => 'Total Siswa', 'value' => $students->count(), 'suffix' => '', 'badge' => 'MySQL Users', 'tone' => 'blue'],
                ['icon' => 'science', 'label' => 'Riwayat Praktikum', 'value' => $histories->count(), 'suffix' => '', 'badge' => 'Database', 'tone' => 'red'],
                ['icon' => 'rate_review', 'label' => 'Sudah Dinilai', 'value' => $gradedCount, 'suffix' => '', 'badge' => $histories->count() - $gradedCount . ' Pending', 'tone' => 'blue'],
                ['icon' => 'error', 'label' => 'Avg. Error Rate', 'value' => number_format($averageError, 2), 'suffix' => '%', 'badge' => $successCount . ' Sesuai', 'tone' => 'orange'],
            ];
        @endphp

        <section class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="metric-card flex min-h-44 flex-col justify-between rounded-2xl p-6 transition hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="grid h-11 w-11 place-items-center rounded-xl {{ $stat['tone'] === 'blue' ? 'bg-[#d6f5f1] text-[#30cfb7]' : ($stat['tone'] === 'red' ? 'bg-[#ac2bd4] text-white' : 'bg-[#ac2bd4] text-white') }}">
                            <span class="material-symbols-outlined">{{ $stat['icon'] }}</span>
                        </div>
                    <span class="rounded-full {{ $stat['tone'] === 'red' ? 'bg-[#d6f5f1] text-[#30cfb7]' : ($stat['tone'] === 'orange' ? 'bg-[#eed5f6] text-[#8a23a9]' : 'bg-[#d6f5f1] text-[#1d7c6e]') }} px-2 py-1 text-xs font-black">{{ $stat['badge'] }}</span>
                    </div>
                    <div class="mt-6">
                        <p class="font-['Geist'] text-xs font-bold uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">{{ $stat['label'] }}</p>
                        <p class="mt-1 font-['Geist'] text-4xl font-bold text-[#071d1a] dark:text-[#eafaf8]">{{ $stat['value'] }}<span class="text-2xl font-normal text-[#135349] dark:text-[#d6f5f1]">{{ $stat['suffix'] }}</span></p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <h3 class="font-['Inter'] text-2xl font-black text-[#071d1a] dark:text-[#eafaf8]">Akun Siswa Terdaftar</h3>
            </div>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4 xl:grid-cols-6">
                @forelse ($students->take(6) as $student)
                    @php $latest = $histories->firstWhere('user_id', $student->id); @endphp
                    <article class="glass-panel cursor-pointer rounded-xl p-4 transition hover:border-[#ac2bd4]/50">
                        <div class="flex items-center justify-between gap-3">
                            <span class="truncate text-xs font-black text-[#135349] dark:text-[#d6f5f1]">{{ $student->name }}</span>
                            <span class="material-symbols-outlined text-[18px] text-[#30cfb7]">person</span>
                        </div>
                        <p class="mt-1 truncate text-[10px] font-bold text-[#135349] dark:text-[#d6f5f1]">{{ $student->kelas ?? '-' }} / {{ $student->nis ?? '-' }}</p>
                        <div class="mt-3 grid grid-cols-3 gap-1">
                            <div class="rounded bg-[#d6f5f1] p-1.5 text-center dark:bg-[#0a2925]">
                                <p class="text-[10px] font-black text-[#135349] dark:text-[#d6f5f1]">T1</p>
                                <p class="text-xs font-black text-[#ac2bd4]">{{ $latest?->suhu_panas ? number_format($latest->suhu_panas, 0) : '-' }}&deg;</p>
                            </div>
                            <div class="rounded bg-[#d6f5f1] p-1.5 text-center dark:bg-[#0a2925]">
                                <p class="text-[10px] font-black text-[#135349] dark:text-[#d6f5f1]">T2</p>
                                <p class="text-xs font-black text-[#30cfb7]">{{ $latest?->suhu_dingin ? number_format($latest->suhu_dingin, 0) : '-' }}&deg;</p>
                            </div>
                            <div class="rounded bg-[#d6f5f1] p-1.5 text-center dark:bg-[#0a2925]">
                                <p class="text-[10px] font-black text-[#135349] dark:text-[#d6f5f1]">Tc</p>
                                <p class="text-xs font-black text-[#8a23a9]">{{ $latest?->suhu_campuran ? number_format($latest->suhu_campuran, 0) : '-' }}&deg;</p>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-xl border border-[#acece2] bg-[#d6f5f1]/80 p-6 text-center font-bold text-[#135349] dark:border-[#27a592]/30 dark:bg-[#0a2925]/45 dark:text-[#d6f5f1]">
                        Belum ada akun siswa di database.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="metric-card overflow-hidden rounded-2xl">
            <div class="border-b border-[#acece2]/70 p-6 dark:border-[#27a592]/30">
                <h3 class="font-['Inter'] text-2xl font-black text-[#071d1a] dark:text-[#eafaf8]">Data Praktikum Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1180px] border-collapse text-left text-sm">
                    <thead class="bg-[#eafaf8] dark:bg-[#0a2925]/70">
                        <tr>
                            @foreach (['Nama Siswa','m1 (g)','m2 (g)','T1 (C)','T2 (C)','Tc (C)','Qlepas (J)','Qterima (J)','Error %','Status','Nilai','Aksi'] as $header)
                                <th class="px-5 py-4 text-center font-['Geist'] text-xs font-black uppercase tracking-[0.08em] text-[#135349] first:text-left last:text-right dark:text-[#d6f5f1]">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#acece2]/50 dark:divide-[#27a592]/20">
                        @forelse ($histories->take(10) as $history)
                            <tr class="group transition hover:bg-[#eafaf8]/60 dark:hover:bg-[#0a2925]/60">
                                <td class="px-5 py-4 font-black text-[#071d1a] dark:text-[#eafaf8]">{{ $history->user->name }}</td>
                                <td class="px-5 py-4 text-center font-['Geist'] font-semibold">{{ $history->massa_panas * 1000 }}</td>
                                <td class="px-5 py-4 text-center font-['Geist'] font-semibold">{{ $history->massa_dingin * 1000 }}</td>
                                <td class="px-5 py-4 text-center font-['Geist'] font-semibold text-[#ac2bd4]">{{ number_format($history->suhu_panas, 1) }}</td>
                                <td class="px-5 py-4 text-center font-['Geist'] font-semibold text-[#30cfb7]">{{ number_format($history->suhu_dingin, 1) }}</td>
                                <td class="px-5 py-4 text-center font-['Geist'] font-semibold text-[#8a23a9]">{{ number_format($history->suhu_campuran, 1) }}</td>
                                <td class="px-5 py-4 text-center font-['Geist'] font-semibold">{{ number_format($history->q_lepas, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-center font-['Geist'] font-semibold">{{ number_format($history->q_terima, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-center font-['Geist'] font-semibold">{{ number_format($history->error_persen, 2) }}%</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="rounded-full px-2 py-1 text-[10px] font-black uppercase {{ $history->status === 'Sesuai Asas Black' ? 'bg-[#d6f5f1] text-[#1d7c6e]' : 'bg-[#f7eafb] text-[#8a23a9]' }}">{{ $history->status }}</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if ($history->nilai !== null)
                                        <span class="font-['Geist'] text-lg font-black text-[#30cfb7]">{{ $history->nilai }}</span>
                                    @else
                                        <span class="rounded-full bg-[#eafaf8] px-2 py-1 text-[10px] font-black text-[#135349] dark:bg-[#0a2925] dark:text-[#d6f5f1]">Pending</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-2 opacity-100 transition md:opacity-0 md:group-hover:opacity-100">
                                        <a href="{{ route('teacher.history') }}" class="rounded p-1.5 hover:bg-[#d6f5f1] dark:hover:bg-[#0a2925]" title="Kelola Nilai"><span class="material-symbols-outlined text-[18px]">rate_review</span></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="px-5 py-10 text-center font-bold text-[#135349] dark:text-[#d6f5f1]">Belum ada riwayat praktikum di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[#acece2]/70 bg-[#eafaf8] p-4 text-center dark:border-[#27a592]/30 dark:bg-[#0a2925]/70">
                <a href="{{ route('teacher.history') }}" class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#ac2bd4] hover:underline dark:text-[#cd80e5]">Kelola semua data</a>
            </div>
        </section>

    </div>
</x-layouts.dashboard>

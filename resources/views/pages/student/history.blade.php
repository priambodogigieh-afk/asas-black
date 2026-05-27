<x-layouts.dashboard
    title="Riwayat Praktikum"
    subtitle="Catatan hasil praktikum yang tersimpan di database untuk akun mahasiswa/siswa yang sedang login."
    role="Siswa"
    :items="$items"
>
    <div class="space-y-6">
        <section class="grid gap-4 md:grid-cols-3">
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Total Riwayat</p>
                <p class="mt-3 font-['Geist'] text-4xl font-bold text-[#071d1a] dark:text-[#eafaf8]">{{ $histories->count() }}</p>
                <p class="mt-2 text-xs font-bold text-[#30cfb7] dark:text-[#83e2d4]">Data dari MySQL</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Rata-rata Error</p>
                <p class="mt-3 font-['Geist'] text-4xl font-bold text-[#071d1a] dark:text-[#eafaf8]">{{ $histories->count() ? number_format($histories->avg('error_persen'), 2) : '0.00' }}%</p>
                <p class="mt-2 text-xs font-bold text-[#8a23a9] dark:text-[#cd80e5]">Semua percobaan</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Sesuai Asas Black</p>
                <p class="mt-3 font-['Geist'] text-4xl font-bold text-[#30cfb7]">{{ $histories->where('status', 'Sesuai Asas Black')->count() }}</p>
                <p class="mt-2 text-xs font-bold text-[#30cfb7]">Status valid</p>
            </article>
        </section>

        <section class="metric-card overflow-hidden rounded-2xl">
            <div class="border-b border-[#acece2]/70 px-6 py-4 dark:border-[#27a592]/30">
                <h2 class="font-['Inter'] text-xl font-black text-[#071d1a] dark:text-[#eafaf8]">Riwayat Saya</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] text-left text-sm">
                    <thead class="bg-[#eafaf8] font-['Geist'] text-xs uppercase tracking-[0.08em] text-[#135349] dark:bg-[#0a2925]/70 dark:text-[#d6f5f1]">
                        <tr>
                            <th class="px-5 py-3">Waktu</th>
                            <th class="px-5 py-3">m panas</th>
                            <th class="px-5 py-3">m dingin</th>
                            <th class="px-5 py-3">Qlepas</th>
                            <th class="px-5 py-3">Qterima</th>
                            <th class="px-5 py-3">Delta Q</th>
                            <th class="px-5 py-3">Error</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Nilai Guru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#acece2]/50 dark:divide-[#27a592]/20">
                        @forelse ($histories as $history)
                            <tr class="transition hover:bg-[#eafaf8]/60 dark:hover:bg-[#0a2925]/60">
                                <td class="px-5 py-4 font-semibold">{{ $history->created_at->format('d M Y H:i') }}</td>
                                <td class="px-5 py-4 font-['Geist'] font-semibold">{{ $history->massa_panas }} kg</td>
                                <td class="px-5 py-4 font-['Geist'] font-semibold">{{ $history->massa_dingin }} kg</td>
                                <td class="px-5 py-4 font-['Geist'] font-semibold text-[#ac2bd4]">{{ number_format($history->q_lepas, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-['Geist'] font-semibold text-[#30cfb7]">{{ number_format($history->q_terima, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-['Geist'] font-semibold">{{ number_format($history->delta_q, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-['Geist'] font-semibold">{{ number_format($history->error_persen, 2) }}%</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-black {{ $history->status === 'Sesuai Asas Black' ? 'bg-[#d6f5f1] text-[#1d7c6e]' : 'bg-[#f7eafb] text-[#8a23a9]' }}">
                                        {{ $history->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    @if ($history->nilai !== null)
                                        <div class="font-['Geist'] text-2xl font-bold text-[#30cfb7]">{{ $history->nilai }}</div>
                                        <div class="mt-1 max-w-[220px] text-xs font-semibold text-[#135349] dark:text-[#d6f5f1]">{{ $history->catatan_nilai ?: 'Tanpa catatan' }}</div>
                                    @else
                                        <span class="rounded-full bg-[#eafaf8] px-2.5 py-1 text-xs font-black text-[#135349] dark:bg-[#0a2925] dark:text-[#d6f5f1]">Belum dinilai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-10 text-center font-bold text-[#135349] dark:text-[#d6f5f1]">
                                    Belum ada riwayat. Buka Praktikum, isi massa air, lalu tekan Hitung Asas Black.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.dashboard>

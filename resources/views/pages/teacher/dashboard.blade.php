<x-layouts.dashboard
    title="Monitoring Termodinamika"
    subtitle=""
    role="Guru"
    :items="$items"
>
    <div class="space-y-6" data-page="teacher-dashboard" data-realtime-sensor-dashboard>
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <span class="font-mono text-xs font-bold uppercase tracking-[0.22em] text-[#006c4e] dark:text-[#cdfef1]">Portal Guru Fisika</span>
                <h2 class="mt-1 font-sans text-3xl font-black text-[#013225] dark:text-[#ffffff]">Monitoring Praktikum Guru</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('teacher.history') }}" class="flex items-center gap-2 rounded-lg bg-[#006c4e] px-5 py-2 font-mono text-xs font-bold uppercase tracking-[0.08em] text-white shadow-md transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[18px]">rate_review</span>
                    Kelola Nilai
                </a>
            </div>
        </div>

        @php
            $stats = [
                ['icon' => 'group', 'label' => 'Total Siswa', 'value' => $students->count(), 'suffix' => '', 'badge' => 'Pengguna MySQL', 'tone' => 'blue'],
                ['icon' => 'science', 'label' => 'Riwayat Praktikum', 'value' => $histories->count(), 'suffix' => '', 'badge' => 'Database', 'tone' => 'red'],
                ['icon' => 'rate_review', 'label' => 'Sudah Dinilai', 'value' => $gradedCount, 'suffix' => '', 'badge' => $histories->count() - $gradedCount . ' Tertunda', 'tone' => 'blue'],
                ['icon' => 'error', 'label' => 'Rata-rata Error', 'value' => number_format($averageError, 2), 'suffix' => '%', 'badge' => $successCount . ' Sesuai', 'tone' => 'orange'],
            ];
        @endphp

        <section class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="metric-card flex min-h-44 flex-col justify-between rounded-2xl p-6 transition hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="grid h-11 w-11 place-items-center rounded-xl {{ $stat['tone'] === 'blue' ? 'bg-[#e6fef8] text-[#006c4e]' : ($stat['tone'] === 'red' ? 'bg-[#006c4e] text-white' : 'bg-[#fff0cc] text-[#7e5700]') }}">
                            <span class="material-symbols-outlined">{{ $stat['icon'] }}</span>
                        </div>
                    <span class="rounded-full {{ $stat['tone'] === 'red' ? 'bg-[#e6fef8] text-[#006c4e]' : ($stat['tone'] === 'orange' ? 'bg-[#fff0cc] text-[#7e5700]' : 'bg-[#e6fef8] text-[#004d36]') }} px-2 py-1 text-xs font-black">{{ $stat['badge'] }}</span>
                    </div>
                    <div class="mt-6">
                        <p class="font-mono text-xs font-bold uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">{{ $stat['label'] }}</p>
                        <p class="mt-1 font-mono text-4xl font-bold text-[#013225] dark:text-[#ffffff]">{{ $stat['value'] }}<span class="text-2xl font-normal text-[#191c1e] dark:text-[#e6fef8]">{{ $stat['suffix'] }}</span></p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <x-temperature-card label="Suhu Air Panas" value="70" tone="red" sensor="DS18B20 A" sensor-key="suhu_panas" />
            <x-temperature-card label="Suhu Air Dingin" value="28" tone="blue" sensor="DS18B20 B" sensor-key="suhu_dingin" />
            <x-temperature-card label="Suhu Campuran" value="45" tone="orange" sensor="DS18B20 C" sensor-key="suhu_campuran" />
        </section>

        {{-- Chart with Integrated MQTT Connection --}}
        <article class="metric-card flex flex-col rounded-2xl p-6">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#006c4e] dark:text-[#cdfef1]">Grafik &amp; Kontrol Realtime</p>
                    <h3 class="mt-1 font-sans text-2xl font-black text-[#013225] dark:text-[#ffffff]">Grafik Suhu Sensor</h3>
                </div>
                <div class="flex flex-col items-start gap-2 rounded-xl border border-[#cdfef1]/40 bg-[#e6fef8]/50 p-3 dark:border-[#03634a]/20 dark:bg-[#013225]/30 sm:flex-row sm:items-center sm:gap-4 md:self-end">
                    <div class="text-left sm:text-right">
                        <p class="text-xs font-bold text-[#191c1e] dark:text-[#e6fef8]" data-mqtt-connect-message data-sensor-status>Menunggu koneksi MQTT</p>
                        <p class="mt-0.5 text-[10px] font-bold text-[#006c4e] dark:text-[#cdfef1]" data-sensor-updated>Diperbarui: -</p>
                    </div>
                    <button type="button" data-mqtt-connect-button class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#006c4e] px-4 py-2 font-mono text-xs font-black uppercase tracking-[0.08em] text-white shadow-md transition hover:bg-[#005a40] active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[18px]">sensors</span>
                        Konek MQTT
                    </button>
                </div>
            </div>
            <div class="chart-shell mt-5 flex-1 min-h-[340px] rounded-xl border border-[#cdfef1]/60 bg-[#e6fef8]/80 p-4 dark:border-[#03634a]/30 dark:bg-[#013225]/45">
                <canvas id="teacherRealtimeChart"></canvas>
            </div>
        </article>
    </div>
</x-layouts.dashboard>

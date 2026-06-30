<x-layouts.dashboard
    :title="$title"
    subtitle=""
    :role="$role"
    :items="$items"
>
    <div class="space-y-6" data-page="monitoring" data-realtime-sensor-dashboard>

        {{-- Page Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="font-mono text-xs font-bold uppercase tracking-[0.22em] text-[#006c4e] dark:text-[#cdfef1]">Sensor IoT DS18B20</span>
                <h2 class="mt-1 font-sans text-3xl font-black text-[#013225] dark:text-[#ffffff]">Monitoring Suhu Realtime</h2>
            </div>
            <p class="rounded-full bg-[#013225] px-4 py-2 font-mono text-xs font-black text-[#cdfef1]" data-sensor-updated>Diperbarui: -</p>
        </div>

        {{-- Sensor Cards --}}
        <section class="grid gap-4 lg:grid-cols-3">
            <x-temperature-card label="Suhu Panas" value="70" tone="red" sensor="DS18B20 A" change="+0.5" sensor-key="suhu_panas" />
            <x-temperature-card label="Suhu Dingin" value="28" tone="blue" sensor="DS18B20 B" change="-0.2" sensor-key="suhu_dingin" />
            <x-temperature-card label="Suhu Campuran" value="45" tone="orange" sensor="DS18B20 C" change="+0.3" sensor-key="suhu_campuran" />
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
                    </div>
                    <button type="button" data-mqtt-connect-button class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#006c4e] px-4 py-2 font-mono text-xs font-black uppercase tracking-[0.08em] text-white shadow-md transition hover:bg-[#005a40] active:scale-[0.98]">
                        <svg class="h-4 w-4 text-current shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                        Konek MQTT
                    </button>
                </div>
            </div>
            <div class="chart-shell mt-5 flex-1 min-h-[340px] rounded-xl border border-[#cdfef1]/60 bg-[#e6fef8]/80 p-4 dark:border-[#03634a]/30 dark:bg-[#013225]/45">
                <canvas id="monitoringChart"></canvas>
            </div>
        </article>
    </div>
</x-layouts.dashboard>

<x-layouts.dashboard
    :title="$title"
    subtitle="Monitoring realtime data sensor DS18B20 dari broker MQTT IoTKita."
    :role="$role"
    :items="$items"
>
    <div class="space-y-6" data-page="monitoring" data-realtime-sensor-dashboard>
        <section class="grid gap-4 lg:grid-cols-3">
            <x-temperature-card label="Suhu Panas" value="70" tone="red" sensor="DS18B20 A" change="+0.5" sensor-key="suhu_panas" />
            <x-temperature-card label="Suhu Dingin" value="28" tone="blue" sensor="DS18B20 B" change="-0.2" sensor-key="suhu_dingin" />
            <x-temperature-card label="Suhu Campuran" value="45" tone="orange" sensor="DS18B20 C" change="+0.3" sensor-key="suhu_campuran" />
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_auto]">
            <article class="metric-card rounded-md p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#30cfb7] dark:text-[#83e2d4]">Status Sensor</p>
                <h2 class="mt-1 text-lg font-black text-[#071d1a] dark:text-[#eafaf8]" data-sensor-status>Menunggu data MQTT</h2>
                <p class="mt-2 text-sm font-bold text-[#135349] dark:text-[#d6f5f1]" data-sensor-updated>Updated: -</p>
            </article>
            <article class="metric-card rounded-md p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#30cfb7] dark:text-[#83e2d4]">LCD Virtual 16x2</p>
                <div class="mt-3 min-w-[260px] rounded-lg border border-[#83e2d4]/30 bg-[#071d1a] p-4 font-mono text-lg font-black leading-7 text-[#ffff99] shadow-inner">
                    <div data-lcd-line-one>Hot:-- Cold:--</div>
                    <div data-lcd-line-two>Mix:--C</div>
                </div>
            </article>
        </section>

        <section>
            <div class="metric-card rounded-md p-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-black text-[#071d1a] dark:text-[#eafaf8]">Grafik Suhu</h2>
                        <p class="mt-1 text-sm text-[#135349] dark:text-[#d6f5f1]">Simulasi pergerakan suhu lokal.</p>
                    </div>
                </div>
                <div class="chart-shell mt-5 h-[380px]">
                    <canvas id="monitoringChart"></canvas>
                </div>
            </div>
        </section>
    </div>
</x-layouts.dashboard>

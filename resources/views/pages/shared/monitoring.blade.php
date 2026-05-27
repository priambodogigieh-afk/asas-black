<x-layouts.dashboard
    :title="$title"
    subtitle="Tampilan monitoring suhu dummy berbasis frontend tanpa koneksi MQTT atau database."
    :role="$role"
    :items="$items"
>
    <div class="space-y-6" data-page="monitoring">
        <section class="grid gap-4 lg:grid-cols-3">
            <x-temperature-card label="Suhu Panas" value="70" tone="red" sensor="DS18B20 A" change="+0.5" />
            <x-temperature-card label="Suhu Dingin" value="28" tone="blue" sensor="DS18B20 B" change="-0.2" />
            <x-temperature-card label="Suhu Campuran" value="45" tone="orange" sensor="DS18B20 C" change="+0.3" />
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

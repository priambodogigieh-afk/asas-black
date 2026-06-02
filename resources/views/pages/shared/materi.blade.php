<x-layouts.dashboard
    title="Materi Pembelajaran"
    subtitle="Ringkasan konsep kalor, Asas Black, sensor suhu, mikrokontroler, dan IoT."
    :role="$role"
    :items="$items"
>
    <div class="space-y-6">
        <section class="metric-card overflow-hidden rounded-md">
            <div class="grid gap-0 lg:grid-cols-[1.05fr_.95fr]">
                <div class="p-6 sm:p-8">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-[#006c4e] dark:text-[#cdfef1]">Physics Concept</p>
                    <h2 class="mt-3 text-3xl font-black text-[#013225] dark:text-[#ffffff]">Hukum Asas Black</h2>
                    <p class="mt-4 leading-7 text-[#191c1e] dark:text-[#e6fef8]">
                        Asas Black menjelaskan bahwa kalor yang dilepas oleh benda bersuhu lebih tinggi akan diterima oleh benda bersuhu lebih rendah hingga tercapai suhu akhir campuran.
                    </p>
                    <div class="mt-5 rounded-md bg-[#013225] p-5 text-sm font-bold text-white dark:bg-[#013225]">
                        Qlepas = Qterima<br>
                        m1 x c x (T1 - Tc) = m2 x c x (Tc - T2)
                    </div>
                </div>
                <div class="sensor-grid border-t border-[#cdfef1] p-6 dark:border-[#03634a]/40 lg:border-l lg:border-t-0">
                    <div class="relative min-h-72">
                        <div class="absolute left-4 top-10 h-28 w-28 rounded-full border-[10px] border-[#006c4e] bg-[#e6fef8] dark:bg-[#006c4e]/10"></div>
                        <div class="absolute right-4 top-10 h-28 w-28 rounded-full border-[10px] border-[#006c4e] bg-[#ffffff] dark:bg-[#006c4e]/10"></div>
                        <div class="absolute left-1/2 top-28 h-32 w-32 -translate-x-1/2 rounded-full border-[10px] border-[#639dcf] bg-[#cdfef1] shadow-xl dark:bg-[#006c4e]/10"></div>
                        <div class="absolute left-28 top-24 h-1 w-36 rotate-[18deg] rounded-full bg-[#639dcf]"></div>
                        <div class="absolute right-28 top-24 h-1 w-36 rotate-[-18deg] rounded-full bg-[#05c793]"></div>
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 rounded-md border border-[#cdfef1] bg-white px-4 py-3 text-center text-xs font-black text-[#191c1e] shadow-sm dark:border-[#03634a]/40 dark:bg-[#013225] dark:text-[#e6fef8]">
                            Diagram perpindahan kalor
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['Kalor','Energi yang berpindah karena perbedaan suhu. Besarnya dipengaruhi massa, kalor jenis, dan perubahan suhu.','bg-[#e6fef8] text-[#006c4e] dark:bg-[#006c4e]/10 dark:text-[#05c793]'],
                ['DS18B20','Sensor suhu digital yang umum digunakan untuk membaca temperatur air secara stabil pada sistem praktikum.','bg-[#ffffff] text-[#004d36] dark:bg-[#006c4e]/10 dark:text-[#cdfef1]'],
                ['NodeMCU ESP8266','Mikrokontroler dengan konektivitas WiFi yang cocok untuk prototipe alat ukur berbasis IoT.','bg-[#e6fef8] text-[#004d36] dark:bg-[#006c4e]/10 dark:text-[#cdfef1]'],
                ['Internet of Things','Konsep perangkat fisik yang dapat membaca kondisi lingkungan dan menampilkan data melalui jaringan.','bg-[#cdfef1] text-[#03634a] dark:bg-[#006c4e]/10 dark:text-[#05c793]'],
            ] as $card)
                <article class="metric-card rounded-md p-5">
                    <span class="rounded-md px-3 py-1.5 text-xs font-black {{ $card[2] }}">{{ $card[0] }}</span>
                    <p class="mt-4 text-sm leading-6 text-[#191c1e] dark:text-[#e6fef8]">{{ $card[1] }}</p>
                </article>
            @endforeach
        </section>

        <section class="metric-card rounded-md p-6">
            <h2 class="text-xl font-black text-[#013225] dark:text-[#ffffff]">Alur Praktikum Digital</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-4">
                @foreach (['Ukur suhu awal air panas dan dingin', 'Campurkan air dalam kalorimeter', 'Baca suhu campuran dari sensor', 'Bandingkan Qlepas dan Qterima'] as $step)
                    <div class="rounded-md border border-[#cdfef1] bg-white p-4 dark:border-[#03634a]/40 dark:bg-[#013225]">
                        <p class="text-sm font-bold text-[#191c1e] dark:text-[#e6fef8]">{{ $step }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-layouts.dashboard>

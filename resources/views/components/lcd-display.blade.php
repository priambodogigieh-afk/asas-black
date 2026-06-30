{{-- Virtual LCD 16x2 Display --}}
<div class="lcd-display inline-block rounded-lg border-[3px] border-[#3a4a2a] bg-[#1a2a0a] p-3 shadow-[0_0_24px_rgba(6,249,184,0.18)] dark:shadow-[0_0_32px_rgba(6,249,184,0.22)]">

    {{-- Top screws --}}
    <div class="mb-2 flex justify-between px-1">
        <div class="h-2.5 w-2.5 rounded-full bg-[#2e3d1e] shadow-inner"></div>
        <div class="h-2.5 w-2.5 rounded-full bg-[#2e3d1e] shadow-inner"></div>
    </div>

    {{-- LCD Screen --}}
    <div class="relative overflow-hidden rounded bg-[#0d1f04] px-3 py-2.5 shadow-inner" style="box-shadow: inset 0 2px 8px rgba(0,0,0,0.6), 0 0 0 2px #2e3d1e;">

        {{-- Scan line overlay --}}
        <div class="pointer-events-none absolute inset-0 opacity-10" style="background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(6,249,184,0.15) 3px, rgba(6,249,184,0.15) 4px);"></div>

        {{-- Row 1: Suhu label --}}
        <p class="lcd-text font-mono text-sm font-bold leading-5 tracking-[0.22em] text-[#06f9b8]" style="text-shadow: 0 0 8px rgba(6,249,184,0.8);">
            T1:<span data-sensor-value="suhu_panas">70.0</span>C
            T2:<span data-sensor-value="suhu_dingin">28.0</span>C
        </p>

        {{-- Row 2: Campuran + status --}}
        <p class="lcd-text mt-0.5 font-mono text-sm font-bold leading-5 tracking-[0.22em] text-[#06f9b8]" style="text-shadow: 0 0 8px rgba(6,249,184,0.8);">
            Tc:<span data-sensor-value="suhu_campuran">45.0</span>C
            <span class="text-[#ffb300]" data-sensor-status style="text-shadow: 0 0 8px rgba(255,179,0,0.8);">IDLE</span>
        </p>
    </div>

    {{-- Bottom screws --}}
    <div class="mt-2 flex justify-between px-1">
        <div class="h-2.5 w-2.5 rounded-full bg-[#2e3d1e] shadow-inner"></div>
        <div class="h-2.5 w-2.5 rounded-full bg-[#2e3d1e] shadow-inner"></div>
    </div>
</div>

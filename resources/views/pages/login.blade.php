<x-layouts.app title="Login - Asas Black Smart Lab">
    <main class="sensor-grid min-h-screen overflow-hidden px-4 py-8 sm:px-6 lg:px-8">
        <section class="relative mx-auto grid min-h-[calc(100vh-4rem)] max-w-6xl items-center gap-10 lg:grid-cols-[1.05fr_.95fr]">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-md border border-[#acece2] bg-[#d6f5f1]/80 px-3 py-2 text-xs font-bold uppercase tracking-[0.22em] text-[#1d7c6e] backdrop-blur dark:border-[#27a592]/40 dark:bg-[#0a2925]/70 dark:text-[#83e2d4]">
                    IoT Physics Education
                </div>
                <h1 class="mt-6 text-4xl font-black leading-tight text-[#071d1a] dark:text-[#eafaf8] sm:text-5xl">
                    Implementasi Alat Peraga Hukum Asas Black Menggunakan Sensor DS18B20 Berbasis Mikrokontroler
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-[#135349] dark:text-[#d6f5f1]">
                    Sistem praktikum kalor untuk siswa dan panel penilaian guru berbasis akun MySQL.
                </p>

                <div class="mt-8 grid max-w-xl grid-cols-3 gap-3">
                    <div class="rounded-md border border-[#eed5f6] bg-[#d6f5f1]/84 p-4 shadow-sm backdrop-blur dark:border-[#ac2bd4]/30 dark:bg-[#0a2925]/70">
                        <p class="text-xs font-bold text-[#135349] dark:text-[#d6f5f1]">Panas</p>
                        <p class="mt-2 text-2xl font-black text-[#ac2bd4]">70&deg;C</p>
                    </div>
                    <div class="rounded-md border border-[#acece2] bg-[#d6f5f1]/84 p-4 shadow-sm backdrop-blur dark:border-[#30cfb7]/30 dark:bg-[#0a2925]/70">
                        <p class="text-xs font-bold text-[#135349] dark:text-[#d6f5f1]">Dingin</p>
                        <p class="mt-2 text-2xl font-black text-[#30cfb7]">28&deg;C</p>
                    </div>
                    <div class="rounded-md border border-[#eed5f6] bg-[#d6f5f1]/84 p-4 shadow-sm backdrop-blur dark:border-[#cd80e5]/30 dark:bg-[#0a2925]/70">
                        <p class="text-xs font-bold text-[#135349] dark:text-[#d6f5f1]">Campuran</p>
                        <p class="mt-2 text-2xl font-black text-[#8a23a9]">45&deg;C</p>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-md p-5 sm:p-7">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold text-[#30cfb7] dark:text-[#83e2d4]">Secure Access</p>
                        <h2 class="mt-1 text-2xl font-black text-[#071d1a] dark:text-[#eafaf8]">Masuk Aplikasi</h2>
                    </div>
                </div>

                <div class="mt-6 rounded-xl border border-[#acece2] bg-[#d6f5f1]/90 p-4 dark:border-[#27a592]/40 dark:bg-[#0a2925]/70">
                    <div class="flex items-start gap-3">
                        <div class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#ac2bd4] text-white">
                            <span class="material-symbols-outlined text-[20px]">login</span>
                        </div>
                        <div>
                            <p class="font-['Inter'] text-base font-black text-[#071d1a] dark:text-[#eafaf8]">Satu Login untuk Guru & Siswa</p>
                            <p class="mt-1 text-sm font-semibold text-[#135349] dark:text-[#d6f5f1]">Masukkan email dan password. Sistem akan otomatis membuka dashboard sesuai role akun di MySQL.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('student.register') }}" class="mt-3 flex items-center justify-center gap-2 rounded-md border border-[#acece2] bg-[#d6f5f1]/90 px-4 py-3 text-center text-sm font-black text-[#ac2bd4] transition hover:bg-[#eafaf8] dark:border-[#27a592]/40 dark:bg-[#0a2925]/70 dark:text-[#cd80e5]">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    Buat Akun Mahasiswa/Siswa
                </a>

                @if ($errors->any())
                    <div class="mt-5 rounded-lg bg-[#f7eafb] px-4 py-3 text-sm font-bold text-[#8a23a9]">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mt-5 rounded-lg bg-[#d6f5f1] px-4 py-3 text-sm font-bold text-[#1d7c6e]">
                        {{ session('success') }}
                    </div>
                @endif

                <form class="mt-6 space-y-4" method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <label class="block">
                        <span class="text-sm font-bold text-[#135349] dark:text-[#d6f5f1]">Email</span>
                        <input name="email" type="email" value="{{ old('email', 'guru@asasblack.test') }}" class="mt-2 w-full rounded-md border border-[#acece2] bg-[#eafaf8] px-4 py-3 text-sm font-semibold outline-none transition focus:border-[#30cfb7] focus:ring-4 focus:ring-[#d6f5f1] dark:border-[#27a592]/40 dark:bg-[#0a2925] dark:focus:ring-[#30cfb7]/10">
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#135349] dark:text-[#d6f5f1]">Password</span>
                        <input name="password" type="password" value="password" class="mt-2 w-full rounded-md border border-[#acece2] bg-[#eafaf8] px-4 py-3 text-sm font-semibold outline-none transition focus:border-[#30cfb7] focus:ring-4 focus:ring-[#d6f5f1] dark:border-[#27a592]/40 dark:bg-[#0a2925] dark:focus:ring-[#30cfb7]/10">
                    </label>
                    <button type="submit" class="w-full rounded-md bg-[#30cfb7] px-5 py-3 text-sm font-black text-[#071d1a] shadow-lg shadow-[#30cfb7]/20 transition hover:bg-[#83e2d4]">
                        Login Dashboard
                    </button>
                </form>
            </div>
        </section>
    </main>
</x-layouts.app>

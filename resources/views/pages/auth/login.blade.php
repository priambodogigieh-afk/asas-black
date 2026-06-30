<x-layouts.app title="Masuk - Asas Black Smart Lab">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-emerald-50/50 via-teal-50/30 to-emerald-100/40 px-4 py-12 text-[#013225] sm:px-6">
        <!-- Ambient Glowing Background Blobs -->
        <div class="absolute -top-40 -left-40 h-[500px] w-[500px] rounded-full bg-emerald-300/20 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-[500px] w-[500px] rounded-full bg-teal-300/25 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 h-[400px] w-[400px] -translate-y-1/2 rounded-full bg-cyan-300/10 blur-3xl"></div>

        <div class="relative z-10 mx-auto grid w-full max-w-6xl items-center gap-8 lg:grid-cols-12 lg:gap-12">
            <!-- Left Info Column -->
            <div class="auth-entrance flex flex-col items-center text-center lg:col-span-7 lg:items-start lg:text-left">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-emerald-100/60 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-emerald-800 ring-1 ring-emerald-200/50 backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Laboratorium Fisika Pintar
                </div>
                
                <h1 class="mb-6 text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl text-[#013225]">
                    Hitung Hukum <br class="hidden lg:block">
                    <span class="bg-gradient-to-r from-emerald-700 via-emerald-800 to-teal-600 bg-clip-text text-transparent">
                        Asas Black
                    </span>
                    dengan IoT
                </h1>
                
                <p class="mb-8 max-w-md text-base font-medium text-emerald-800/80 sm:text-lg">
                    Pantau praktikum pertukaran kalor secara realtime dan simpan riwayat pengujian laboratorium Anda secara otomatis.
                </p>

                <div class="relative flex justify-center w-full max-w-md lg:max-w-xl">
                    <div class="absolute inset-0 -z-10 rounded-full bg-radial from-emerald-400/20 to-transparent blur-2xl"></div>
                    <img
                        src="{{ asset('images/illustrations/lab-technician.png') }}"
                        alt="Ilustrasi teknisi laboratorium"
                        class="auth-illustration h-auto max-h-72 w-full max-w-xs object-contain sm:max-h-80 lg:max-h-[380px] lg:max-w-lg"
                    >
                </div>
            </div>

            <!-- Right Login Form Column -->
            <section class="auth-card auth-entrance relative w-full max-w-md justify-self-center rounded-3xl border border-white/60 bg-white/70 p-6 shadow-[0_20px_50px_rgba(0,108,78,0.06)] backdrop-blur-xl sm:p-8 lg:col-span-5 lg:justify-self-end">
                <div class="auth-field mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold tracking-tight text-[#013225]">Masuk</h2>
                    <p class="mt-2.5 text-sm font-medium text-emerald-800/70">Akses akun dashboard praktikum Anda di bawah ini.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-bubblegum-pink-200 bg-bubblegum-pink-50/80 px-4 py-3.5 text-sm font-semibold text-bubblegum-pink-700 backdrop-blur-md">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-bubblegum-pink-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50/80 px-4 py-3.5 text-sm font-semibold text-emerald-800 backdrop-blur-md">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-emerald-800 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <form class="space-y-6" method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="auth-field">
                        <label class="block text-sm font-bold text-emerald-950">Email</label>
                        <div class="relative mt-2">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                class="w-full rounded-2xl border border-emerald-200/80 bg-white/50 pl-12 pr-4 py-3.5 text-sm text-[#013225] outline-none transition placeholder:text-emerald-800/40 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                placeholder="nama@email.com"
                            >
                        </div>
                    </div>

                    <div class="auth-field">
                        <label class="block text-sm font-bold text-emerald-950">Password</label>
                        <div class="relative mt-2">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="w-full rounded-2xl border border-emerald-200/80 bg-white/50 pl-12 pr-4 py-3.5 text-sm text-[#013225] outline-none transition placeholder:text-emerald-800/40 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                placeholder="Masukkan password"
                            >
                        </div>
                    </div>

                    <div class="auth-field flex flex-col gap-4 text-sm sm:flex-row sm:items-center sm:justify-between font-medium">
                        <label class="inline-flex items-center gap-2.5 text-emerald-950 cursor-pointer select-none">
                            <input
                                name="remember"
                                type="checkbox"
                                value="1"
                                class="h-4.5 w-4.5 rounded-lg border-emerald-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0"
                            >
                            <span>Ingat saya</span>
                        </label>

                        <a href="#" class="font-bold text-emerald-700 transition hover:text-emerald-800 hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="auth-button auth-field w-full rounded-2xl bg-gradient-to-r from-emerald-600 to-emerald-700 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 hover:from-emerald-700 hover:to-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-500/20 active:scale-[0.98] transition-all"
                    >
                        Masuk ke Dashboard
                    </button>
                </form>

                <p class="auth-field mt-8 text-center text-sm font-semibold text-emerald-950">
                    Belum punya akun siswa?
                    <a href="{{ route('student.register') }}" class="font-bold text-emerald-700 transition hover:text-emerald-800 hover:underline">
                        Daftar Sekarang
                    </a>
                </p>
            </section>
        </div>
    </main>
</x-layouts.app>


<x-layouts.app title="Daftar Siswa - Asas Black Smart Lab">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-emerald-50/50 via-teal-50/30 to-emerald-100/40 px-4 py-12 text-[#013225] sm:px-6">
        <!-- Ambient Glowing Background Blobs -->
        <div class="absolute -top-40 -left-40 h-[500px] w-[500px] rounded-full bg-emerald-300/20 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-[500px] w-[500px] rounded-full bg-teal-300/25 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 h-[400px] w-[400px] -translate-y-1/2 rounded-full bg-cyan-300/10 blur-3xl"></div>

        <div class="relative z-10 mx-auto grid w-full max-w-7xl items-center gap-8 lg:grid-cols-12 lg:gap-12">
            <!-- Left Column (Illustration) -->
            <div class="auth-entrance flex flex-col items-center justify-center lg:col-span-5 lg:items-start">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-emerald-100/60 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-emerald-800 ring-1 ring-emerald-200/50 backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Akun Siswa Baru
                </div>
                <h1 class="mb-6 text-3xl font-extrabold tracking-tight text-[#013225] text-center lg:text-left">
                    Bergabung dengan <br>
                    <span class="bg-gradient-to-r from-emerald-700 via-emerald-800 to-teal-600 bg-clip-text text-transparent">Smart Lab Asas Black</span>
                </h1>
                <div class="relative flex justify-center w-full">
                    <div class="absolute inset-0 -z-10 rounded-full bg-radial from-emerald-400/20 to-transparent blur-2xl"></div>
                    <img
                        src="{{ asset('images/illustrations/lab-technician.png') }}"
                        alt="Ilustrasi teknisi laboratorium"
                        class="auth-illustration h-auto max-h-64 w-full max-w-xs object-contain sm:max-h-80 lg:max-h-[440px] lg:max-w-md"
                    >
                </div>
            </div>

            <!-- Right Column (Form) -->
            <section class="auth-card auth-entrance relative w-full max-w-2xl justify-self-center rounded-3xl border border-white/60 bg-white/70 p-6 shadow-[0_20px_50px_rgba(0,108,78,0.06)] backdrop-blur-xl sm:p-8 lg:col-span-7 lg:justify-self-start">
                <div class="auth-field mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold tracking-tight text-[#013225]">Daftar Siswa</h2>
                    <p class="mt-2 text-sm font-medium text-emerald-800/70">Isi form di bawah ini secara lengkap untuk mendaftarkan akun siswa baru Anda.</p>
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

                <form class="space-y-6" method="POST" action="{{ route('student.register.store') }}">
                    @csrf

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="auth-field">
                            <label class="block text-sm font-bold text-emerald-950">Nama Lengkap</label>
                            <div class="relative mt-2">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <input
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    autocomplete="name"
                                    required
                                    class="w-full rounded-2xl border border-emerald-200/80 bg-white/50 pl-12 pr-4 py-3.5 text-sm text-[#013225] outline-none transition placeholder:text-emerald-800/40 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                    placeholder="Nama siswa"
                                >
                            </div>
                        </div>

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
                    </div>

                    <div class="grid gap-6 sm:grid-cols-3">
                        <div class="auth-field">
                            <label class="block text-sm font-bold text-emerald-950">Kelas</label>
                            <div class="relative mt-2">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                                <select
                                    name="kelas"
                                    required
                                    class="w-full rounded-2xl border border-emerald-200/80 bg-white/50 pl-12 pr-10 py-3.5 text-sm text-[#013225] outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 appearance-none"
                                >
                                    <option value="" class="text-emerald-800/40">Pilih kelas</option>
                                    @foreach (['XI IPA 1', 'XI IPA 2', 'XI IPA 3', 'XII IPA 1'] as $kelas)
                                        <option value="{{ $kelas }}" @selected(old('kelas') === $kelas)>{{ $kelas }}</option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 pointer-events-none select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <div class="auth-field">
                            <label class="block text-sm font-bold text-emerald-950">NIS</label>
                            <div class="relative mt-2">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.333 0 4 1 4 2v1H5v-1c0-1 2.667-2 4-2z" />
                                </svg>
                                <input
                                    name="nis"
                                    type="text"
                                    value="{{ old('nis') }}"
                                    required
                                    inputmode="numeric"
                                    class="w-full rounded-2xl border border-emerald-200/80 bg-white/50 pl-12 pr-4 py-3.5 text-sm text-[#013225] outline-none transition placeholder:text-emerald-800/40 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                    placeholder="NIS"
                                >
                            </div>
                        </div>

                        <div class="auth-field">
                            <label class="block text-sm font-bold text-emerald-950">Jurusan</label>
                            <div class="relative mt-2">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                <select
                                    name="jurusan"
                                    required
                                    class="w-full rounded-2xl border border-emerald-200/80 bg-white/50 pl-12 pr-10 py-3.5 text-sm text-[#013225] outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 appearance-none"
                                >
                                    <option value="" class="text-emerald-800/40">Pilih jurusan</option>
                                    @foreach (['IPA', 'IPS', 'Teknik Komputer', 'Rekayasa Perangkat Lunak'] as $jurusan)
                                        <option value="{{ $jurusan }}" @selected(old('jurusan') === $jurusan)>{{ $jurusan }}</option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 pointer-events-none select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="auth-field">
                            <label class="block text-sm font-bold text-emerald-950">Password</label>
                            <div class="relative mt-2">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <input
                                    name="password"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    minlength="6"
                                    class="w-full rounded-2xl border border-emerald-200/80 bg-white/50 pl-12 pr-4 py-3.5 text-sm text-[#013225] outline-none transition placeholder:text-emerald-800/40 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                    placeholder="Minimal 6 karakter"
                                >
                            </div>
                        </div>

                        <div class="auth-field">
                            <label class="block text-sm font-bold text-emerald-950">Konfirmasi Password</label>
                            <div class="relative mt-2">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-emerald-700/60 select-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <input
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    minlength="6"
                                    class="w-full rounded-2xl border border-emerald-200/80 bg-white/50 pl-12 pr-4 py-3.5 text-sm text-[#013225] outline-none transition placeholder:text-emerald-800/40 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                    placeholder="Ulangi password"
                                >
                            </div>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="auth-button auth-field w-full rounded-2xl bg-gradient-to-r from-emerald-600 to-emerald-700 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 hover:from-emerald-700 hover:to-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-500/20 active:scale-[0.98] transition-all"
                    >
                        Daftar Akun Baru
                    </button>
                </form>

                <p class="auth-field mt-8 text-center text-sm font-semibold text-emerald-950">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-bold text-emerald-700 transition hover:text-emerald-800 hover:underline">
                        Masuk Disini
                    </a>
                </p>
            </section>
        </div>
    </main>
</x-layouts.app>


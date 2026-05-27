<x-layouts.app title="Buat Akun Mahasiswa/Siswa - Asas Black Lab">
    <main class="sensor-grid relative min-h-screen overflow-hidden px-4 py-8 sm:px-6 lg:px-8">
        <section class="relative mx-auto grid min-h-[calc(100vh-4rem)] max-w-6xl items-center gap-8 lg:grid-cols-[.9fr_1.1fr]">
            <div>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg border border-[#acece2] bg-[#d6f5f1]/90 px-4 py-2 text-sm font-black text-[#135349] transition hover:bg-[#eafaf8] dark:border-[#27a592]/40 dark:bg-[#0a2925]/70 dark:text-[#eafaf8]">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Login
                </a>
                <p class="mt-8 font-['Geist'] text-xs font-black uppercase tracking-[0.22em] text-[#30cfb7] dark:text-[#83e2d4]">Student Access</p>
                <h1 class="mt-3 font-['Inter'] text-4xl font-black leading-tight text-[#071d1a] dark:text-[#eafaf8] sm:text-5xl">Buat Akun Mahasiswa/Siswa</h1>
                <p class="mt-5 max-w-xl text-base leading-7 text-[#135349] dark:text-[#d6f5f1]">
                    Akun siswa disimpan ke MySQL dan langsung digunakan untuk akses praktikum, riwayat, serta nilai dari guru.
                </p>

                <div class="mt-8 grid max-w-xl grid-cols-2 gap-3">
                    <div class="metric-card rounded-2xl p-5">
                        <span class="material-symbols-outlined text-[#ac2bd4]">badge</span>
                        <p class="mt-3 font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Identitas</p>
                        <p class="mt-1 text-sm font-semibold">NIS dan jurusan siswa</p>
                    </div>
                    <div class="metric-card rounded-2xl p-5">
                        <span class="material-symbols-outlined text-[#30cfb7]">school</span>
                        <p class="mt-3 font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Kelas</p>
                        <p class="mt-1 text-sm font-semibold">Akses praktikum mandiri</p>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-2xl p-5 sm:p-7">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.18em] text-[#ac2bd4] dark:text-[#cd80e5]">Create Account</p>
                        <h2 class="mt-2 font-['Inter'] text-2xl font-black text-[#071d1a] dark:text-[#eafaf8]">Data Mahasiswa/Siswa</h2>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mt-5 rounded-lg bg-[#f7eafb] px-4 py-3 text-sm font-bold text-[#8a23a9]">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="mt-6 space-y-4" method="POST" action="{{ route('student.register.store') }}">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-bold text-[#135349] dark:text-[#d6f5f1]">Nama Lengkap</span>
                            <input name="name" type="text" value="{{ old('name', 'Alya Prameswari') }}" required class="mt-2 w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-4 py-3 text-sm font-bold outline-none focus:border-[#ac2bd4] focus:ring-4 focus:ring-[#f7eafb] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-[#135349] dark:text-[#d6f5f1]">Email</span>
                            <input name="email" type="email" value="{{ old('email', 'alya@student.lab') }}" required class="mt-2 w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-4 py-3 text-sm font-bold outline-none focus:border-[#ac2bd4] focus:ring-4 focus:ring-[#f7eafb] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                        </label>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <label class="block">
                            <span class="text-sm font-bold text-[#135349] dark:text-[#d6f5f1]">Kelas</span>
                            <select name="kelas" required class="mt-2 w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-4 py-3 text-sm font-bold outline-none focus:border-[#ac2bd4] focus:ring-4 focus:ring-[#f7eafb] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                                @foreach (['XI IPA 1', 'XI IPA 2', 'XI IPA 3', 'XII IPA 1'] as $kelas)
                                    <option @selected(old('kelas', 'XI IPA 2') === $kelas)>{{ $kelas }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-[#135349] dark:text-[#d6f5f1]">NIS</span>
                            <input name="nis" type="text" value="{{ old('nis', '11021') }}" required inputmode="numeric" class="mt-2 w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-4 py-3 text-sm font-bold outline-none focus:border-[#ac2bd4] focus:ring-4 focus:ring-[#f7eafb] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-[#135349] dark:text-[#d6f5f1]">Jurusan</span>
                            <select name="jurusan" required class="mt-2 w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-4 py-3 text-sm font-bold outline-none focus:border-[#ac2bd4] focus:ring-4 focus:ring-[#f7eafb] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                                @foreach (['IPA', 'IPS', 'Teknik Komputer', 'Rekayasa Perangkat Lunak'] as $jurusan)
                                    <option @selected(old('jurusan', 'IPA') === $jurusan)>{{ $jurusan }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-bold text-[#135349] dark:text-[#d6f5f1]">Password</span>
                            <input name="password" type="password" value="password" required minlength="6" class="mt-2 w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-4 py-3 text-sm font-bold outline-none focus:border-[#ac2bd4] focus:ring-4 focus:ring-[#f7eafb] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-[#135349] dark:text-[#d6f5f1]">Konfirmasi Password</span>
                            <input name="password_confirmation" type="password" value="password" required minlength="6" class="mt-2 w-full rounded-lg border border-[#acece2] bg-[#eafaf8] px-4 py-3 text-sm font-bold outline-none focus:border-[#ac2bd4] focus:ring-4 focus:ring-[#f7eafb] dark:border-[#27a592]/40 dark:bg-[#0a2925]">
                        </label>
                    </div>

                    <div class="rounded-lg bg-[#eafaf8] px-4 py-3 text-xs font-bold text-[#135349] dark:bg-[#0a2925] dark:text-[#d6f5f1]">
                        Data akun akan disimpan ke tabel users MySQL.
                    </div>

                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#ac2bd4] px-5 py-4 font-black text-white shadow-lg transition hover:opacity-95 active:scale-[0.99]">
                        <span class="material-symbols-outlined text-[20px]">person_add</span>
                        Buat Akun
                    </button>
                    <a href="{{ route('student.praktikum') }}" class="block rounded-xl border border-[#acece2] bg-[#eafaf8] px-5 py-4 text-center font-black text-[#071d1a] transition hover:bg-[#eafaf8] dark:border-[#27a592]/40 dark:bg-[#0a2925] dark:text-[#eafaf8]">
                        Lanjut ke Praktikum
                    </a>
                </form>
            </div>
        </section>
    </main>
</x-layouts.app>

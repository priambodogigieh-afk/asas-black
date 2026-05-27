<x-layouts.dashboard
    title="Data Siswa"
    subtitle="Daftar akun mahasiswa/siswa yang tersimpan di database MySQL."
    role="Guru"
    :items="$items"
>
    <div class="space-y-6">
        <section class="grid gap-4 md:grid-cols-3">
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Total Siswa</p>
                <p class="mt-3 font-['Geist'] text-4xl font-bold">{{ $students->count() }}</p>
                <p class="mt-2 text-xs font-bold text-[#30cfb7] dark:text-[#83e2d4]">Tabel users</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Kelas Terdata</p>
                <p class="mt-3 font-['Geist'] text-4xl font-bold">{{ $students->pluck('kelas')->filter()->unique()->count() }}</p>
                <p class="mt-2 text-xs font-bold text-[#8a23a9] dark:text-[#cd80e5]">Dari akun siswa</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-['Geist'] text-xs font-black uppercase tracking-[0.12em] text-[#135349] dark:text-[#d6f5f1]">Jurusan</p>
                <p class="mt-3 font-['Geist'] text-4xl font-bold">{{ $students->pluck('jurusan')->filter()->unique()->count() }}</p>
                <p class="mt-2 text-xs font-bold text-[#ac2bd4] dark:text-[#cd80e5]">Unik</p>
            </article>
        </section>

        <section class="metric-card overflow-hidden rounded-2xl">
            <div class="border-b border-[#acece2]/70 px-6 py-4 dark:border-[#27a592]/30">
                <h2 class="font-['Inter'] text-xl font-black">Daftar Akun Siswa</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[860px] text-left text-sm">
                    <thead class="bg-[#eafaf8] font-['Geist'] text-xs uppercase tracking-[0.08em] text-[#135349] dark:bg-[#0a2925]/70 dark:text-[#d6f5f1]">
                        <tr>
                            <th class="px-5 py-3">Nama</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Kelas</th>
                            <th class="px-5 py-3">NIS</th>
                            <th class="px-5 py-3">Jurusan</th>
                            <th class="px-5 py-3">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#acece2]/50 dark:divide-[#27a592]/20">
                        @forelse ($students as $student)
                            <tr class="transition hover:bg-[#eafaf8]/60 dark:hover:bg-[#0a2925]/60">
                                <td class="px-5 py-4 font-black">{{ $student->name }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $student->email }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $student->kelas ?? '-' }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $student->nis ?? '-' }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $student->jurusan ?? '-' }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $student->created_at?->format('d M Y H:i') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center font-bold text-[#135349] dark:text-[#d6f5f1]">Belum ada akun siswa di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.dashboard>

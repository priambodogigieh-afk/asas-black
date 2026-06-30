<x-layouts.dashboard
    title="Penilaian Praktikum"
    subtitle=""
    role="Guru"
    :items="$items"
>
    <div class="space-y-6">
        @php
            $activeSummary = collect($classSummaries)->firstWhere('name', $selectedClass);
            $pendingCount = $activeSummary['pending_count'] ?? $histories->whereNull('nilai')->count();
            $gradedCount = $activeSummary['graded_count'] ?? $histories->whereNotNull('nilai')->count();
        @endphp

        <section class="grid gap-4 md:grid-cols-4">
            <article class="metric-card rounded-2xl p-5">
                <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Kelas Aktif</p>
                <p class="mt-3 font-mono text-3xl font-bold break-words">{{ $selectedClass ?: '-' }}</p>
                <p class="mt-2 text-xs font-bold text-[#006c4e] dark:text-[#cdfef1]">Kategori penilaian</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Data Kelas</p>
                <p class="mt-3 font-mono text-4xl font-bold">{{ $histories->count() }}</p>
                <p class="mt-2 text-xs font-bold text-[#006c4e] dark:text-[#05c793]">Riwayat praktikum</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Sudah Dinilai</p>
                <p class="mt-3 font-mono text-4xl font-bold text-[#006c4e]">{{ $gradedCount }}</p>
                <p class="mt-2 text-xs font-bold text-[#006c4e]">Nilai tersimpan</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Belum Dinilai</p>
                <p class="mt-3 font-mono text-4xl font-bold text-[#006c4e]">{{ $pendingCount }}</p>
                <p class="mt-2 text-xs font-bold text-[#006c4e] dark:text-[#05c793]">Menunggu penilaian</p>
            </article>
        </section>

        <section class="metric-card rounded-2xl p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#006c4e] dark:text-[#cdfef1]">Kategori Per Kelas</p>
                    <h2 class="mt-1 font-sans text-xl font-black">Pilih kelas untuk penilaian</h2>
                </div>
                <div class="flex items-center gap-3">
                    <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Rata-rata Error</p>
                    <p class="font-mono text-lg font-bold">{{ $histories->count() ? number_format($histories->avg('error_persen'), 2) : '0.00' }}%</p>
                </div>
            </div>

            <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                @forelse ($classSummaries as $summary)
                    <a href="{{ route('teacher.history', ['kelas' => $summary['name']]) }}"
                        class="rounded-xl border p-4 transition {{ $selectedClass === $summary['name'] ? 'border-[#006c4e] bg-[#ffffff] shadow-sm dark:border-[#05c793] dark:bg-[#013225]' : 'border-[#cdfef1] bg-[#e6fef8]/80 hover:border-[#006c4e]/50 dark:border-[#03634a]/30 dark:bg-[#013225]/45' }}">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="break-words font-sans text-lg font-black">{{ $summary['name'] }}</p>
                                <p class="mt-1 text-xs font-bold text-[#191c1e] dark:text-[#e6fef8]">{{ $summary['students_count'] }} siswa</p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-xs font-black {{ $summary['pending_count'] > 0 ? 'bg-[#e6fef8] text-[#006c4e]' : 'bg-[#e6fef8] text-[#004d36]' }}">
                                {{ $summary['pending_count'] }} tertunda
                            </span>
                        </div>
                        <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-lg bg-[#e6fef8] p-2 dark:bg-[#013225]">
                                <p class="font-mono text-lg font-black">{{ $summary['histories_count'] }}</p>
                                <p class="text-[10px] font-black uppercase text-[#191c1e] dark:text-[#e6fef8]">Data</p>
                            </div>
                            <div class="rounded-lg bg-[#e6fef8] p-2 dark:bg-[#013225]">
                                <p class="font-mono text-lg font-black text-[#006c4e]">{{ $summary['graded_count'] }}</p>
                                <p class="text-[10px] font-black uppercase text-[#191c1e] dark:text-[#e6fef8]">Dinilai</p>
                            </div>
                            <div class="rounded-lg bg-[#e6fef8] p-2 dark:bg-[#013225]">
                                <p class="font-mono text-lg font-black text-[#006c4e]">{{ $summary['average_score'] ? number_format($summary['average_score'], 1) : '-' }}</p>
                                <p class="text-[10px] font-black uppercase text-[#191c1e] dark:text-[#e6fef8]">Rerata</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="rounded-xl border border-[#cdfef1] bg-[#e6fef8]/80 p-6 text-center font-bold text-[#191c1e] dark:border-[#03634a]/30 dark:bg-[#013225]/45 dark:text-[#e6fef8]">
                        Belum ada data kelas pada akun siswa.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="metric-card overflow-hidden rounded-2xl">
            <div class="border-b border-[#cdfef1]/70 px-6 py-4 dark:border-[#03634a]/30">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <h2 class="font-sans text-xl font-black">Penilaian Kelas {{ $selectedClass ?: '-' }}</h2>
                    @if ($selectedClass && $histories->isNotEmpty())
                        <a href="{{ route('teacher.history.export', ['kelas' => $selectedClass]) }}" class="inline-flex items-center gap-2 rounded-lg bg-[#006c4e] px-4 py-2 font-mono text-xs font-black uppercase tracking-[0.08em] text-white shadow-md transition hover:bg-[#005a40] active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[18px]">download_for_offline</span>
                            Ekspor ke Excel
                        </a>
                    @endif
                </div>
                @if (session('success'))
                    <div class="mt-3 rounded-lg bg-[#e6fef8] px-4 py-3 text-sm font-bold text-[#004d36]">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mt-3 rounded-lg bg-[#e6fef8] px-4 py-3 text-sm font-bold text-[#006c4e]">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1600px] text-left text-sm">
                    <thead class="bg-[#ffffff] font-mono text-xs uppercase tracking-[0.08em] text-[#191c1e] dark:bg-[#013225]/70 dark:text-[#e6fef8]">
                        <tr>
                            <th class="px-5 py-3">Waktu</th>
                            <th class="px-5 py-3">Nama</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Kelas</th>
                            <th class="px-5 py-3">NIS</th>
                            <th class="px-5 py-3">m1</th>
                            <th class="px-5 py-3">T1</th>
                            <th class="px-5 py-3">m2</th>
                            <th class="px-5 py-3">T2</th>
                            <th class="px-5 py-3">Tc</th>
                            <th class="px-5 py-3">Qlepas</th>
                            <th class="px-5 py-3">Qterima</th>
                            <th class="px-5 py-3">Error</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Nilai</th>
                            <th class="px-5 py-3">Kelola Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cdfef1]/50 dark:divide-[#03634a]/20">
                        @forelse ($histories as $history)
                            <tr class="transition hover:bg-[#ffffff]/60 dark:hover:bg-[#013225]/60">
                                <td class="px-5 py-4 font-semibold">{{ $history->created_at->format('d M Y H:i') }}</td>
                                <td class="px-5 py-4 font-black">{{ $history->user->name }}</td>
                                <td class="px-5 py-4 font-semibold break-all">{{ $history->user->email }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $history->user->kelas ?? '-' }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $history->user->nis ?? '-' }}</td>
                                <td class="px-5 py-4 font-mono">{{ $history->massa_panas }} kg</td>
                                <td class="px-5 py-4 font-mono text-[#eb1446] dark:text-[#f7a1b5]">{{ number_format($history->suhu_panas, 1) }} °C</td>
                                <td class="px-5 py-4 font-mono">{{ $history->massa_dingin }} kg</td>
                                <td class="px-5 py-4 font-mono text-[#006c4e] dark:text-[#06f9b8]">{{ number_format($history->suhu_dingin, 1) }} °C</td>
                                <td class="px-5 py-4 font-mono text-[#b18000] dark:text-[#ffb300]">{{ number_format($history->suhu_campuran, 1) }} °C</td>
                                <td class="px-5 py-4 font-mono text-[#006c4e]">{{ number_format($history->q_lepas, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-mono text-[#006c4e]">{{ number_format($history->q_terima, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-mono">{{ number_format($history->error_persen, 2) }}%</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-black {{ in_array($history->status, ['SESUAI HUKUM ASAS BLACK', 'Sesuai Asas Black'], true) ? 'bg-[#e6fef8] text-[#004d36]' : 'bg-[#e6fef8] text-[#006c4e]' }}">
                                        {{ $history->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    @if ($history->nilai !== null)
                                        <div class="font-mono text-2xl font-bold text-[#006c4e]">{{ $history->nilai }}</div>
                                        <div class="mt-1 max-w-[220px] text-xs font-semibold text-[#191c1e] dark:text-[#e6fef8]">{{ $history->catatan_nilai ?: 'Tanpa catatan' }}</div>
                                        @if ($history->status_penilaian)
                                            <div class="mt-1 inline-flex rounded-full {{ $history->status_penilaian === 'Lulus' ? 'bg-[#e6fef8] text-[#004d36]' : 'bg-[#e6fef8] text-[#006c4e]' }} px-2 py-1 text-[10px] font-black uppercase">{{ $history->status_penilaian }}</div>
                                        @endif
                                        @if ($history->dinilai_pada)
                                            <div class="mt-1 text-[10px] font-bold text-[#004d36]">Dinilai {{ $history->dinilai_pada->format('d M Y H:i') }}</div>
                                        @endif
                                    @else
                                        <span class="rounded-full bg-[#ffffff] px-2.5 py-1 text-xs font-black text-[#191c1e] dark:bg-[#013225] dark:text-[#e6fef8]">Belum dinilai</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="grid min-w-[260px] gap-2">
                                        <form id="grade-form-{{ $history->id }}" method="POST" action="{{ route('teacher.history.grade', ['history' => $history, 'kelas' => $selectedClass]) }}" class="grid gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <div class="grid grid-cols-[80px_1fr] gap-2">
                                                <input name="nilai" type="number" min="0" max="100" value="{{ old('nilai', $history->nilai ?? '') }}" placeholder="0-100" required class="rounded-lg border border-[#cdfef1] bg-[#ffffff] px-3 py-2 font-mono text-sm font-bold outline-none focus:border-[#006c4e] dark:border-[#03634a]/40 dark:bg-[#013225]">
                                                <input name="catatan_nilai" type="text" value="{{ old('catatan_nilai', $history->catatan_nilai ?? '') }}" placeholder="Catatan opsional" class="rounded-lg border border-[#cdfef1] bg-[#ffffff] px-3 py-2 text-sm font-semibold outline-none focus:border-[#006c4e] dark:border-[#03634a]/40 dark:bg-[#013225]">
                                            </div>
                                            <select name="status_penilaian" required class="rounded-lg border border-[#cdfef1] bg-[#ffffff] px-3 py-2 text-sm font-bold outline-none focus:border-[#006c4e] dark:border-[#03634a]/40 dark:bg-[#013225]">
                                                <option value="Lulus" @selected(old('status_penilaian', $history->status_penilaian ?? 'Lulus') === 'Lulus')>Lulus</option>
                                                <option value="Revisi" @selected(old('status_penilaian', $history->status_penilaian ?? '') === 'Revisi')>Revisi</option>
                                            </select>
                                        </form>
                                        <button type="submit" form="grade-form-{{ $history->id }}" class="w-full rounded-lg bg-[#006c4e] px-3 py-2 text-xs font-black text-white transition hover:bg-[#005a40]">
                                            {{ $history->nilai === null ? 'Beri Nilai' : 'Perbarui Nilai' }}
                                        </button>

                                        {{-- Garis pemisah + Hapus Seluruh Riwayat --}}
                                        <div class="mt-1 border-t border-[#cdfef1]/60 pt-2 dark:border-[#03634a]/30">
                                            <form id="delete-form-{{ $history->id }}" method="POST" action="{{ route('teacher.history.destroy', ['history' => $history, 'kelas' => $selectedClass]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    data-delete-trigger
                                                    data-form-id="delete-form-{{ $history->id }}"
                                                    data-student-name="{{ $history->user->name }}"
                                                    class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg border border-red-300 bg-red-100 px-3 py-2 text-xs font-black text-red-700 transition hover:bg-red-200 dark:border-red-800/50 dark:bg-red-950/50 dark:text-red-300 dark:hover:bg-red-900/60">
                                                    <span class="material-symbols-outlined text-[14px]">delete_forever</span>
                                                    Hapus Riwayat
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="px-5 py-10 text-center font-bold text-[#191c1e] dark:text-[#e6fef8]">Belum ada riwayat praktikum tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    {{-- Custom Delete Confirmation Modal (teleported to body via JS) --}}
    <template id="delete-modal-template">
        <div id="delete-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center px-4" style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl transition-all duration-200 dark:bg-[#0d1f04]" id="delete-modal-box" style="border:1px solid rgba(220,38,38,0.25);transform:scale(0.95);transition:transform 0.2s;">
                <div class="flex items-start gap-4">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl" style="background:#fee2e2;">
                        <span class="material-symbols-outlined text-[26px]" style="color:#dc2626;">delete_forever</span>
                    </div>
                    <div>
                        <h3 class="font-sans text-lg font-black text-[#1a1a1a] dark:text-white">Hapus Riwayat Praktikum?</h3>
                        <p class="mt-1 text-sm font-semibold text-[#4b5563] dark:text-[#9ca3af]">Data riwayat praktikum milik <span id="delete-modal-name" class="font-black text-[#1a1a1a] dark:text-white"></span> akan dihapus.</p>
                    </div>
                </div>
                <div class="mt-4 rounded-xl px-4 py-3" style="background:#fef2f2;border:1px solid #fecaca;">
                    <p class="text-xs font-bold" style="color:#b91c1c;">⚠️ Tindakan ini tidak dapat dibatalkan. Data akan hilang secara permanen.</p>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button id="delete-modal-cancel" type="button" class="rounded-xl border border-[#cdfef1] bg-white px-5 py-2.5 text-sm font-black text-[#013225] transition hover:bg-[#e6fef8] dark:border-[#03634a]/40 dark:bg-[#013225] dark:text-[#cdfef1]">
                        Batal
                    </button>
                    <button id="delete-modal-confirm" type="button" class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-black text-white transition" style="background:#dc2626;" onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                        <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Teleport modal from template to body so position:fixed works
            var tpl = document.getElementById('delete-modal-template');
            if (tpl) {
                document.body.appendChild(tpl.content.cloneNode(true));
            }

            var modal      = document.getElementById('delete-modal');
            var modalBox   = document.getElementById('delete-modal-box');
            var nameEl     = document.getElementById('delete-modal-name');
            var cancelBtn  = document.getElementById('delete-modal-cancel');
            var confirmBtn = document.getElementById('delete-modal-confirm');
            var targetForm = null;

            function openModal(formId, studentName) {
                targetForm = document.getElementById(formId);
                nameEl.textContent = studentName;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                requestAnimationFrame(function () {
                    modalBox.style.transform = 'scale(1)';
                });
            }

            function closeModal() {
                modalBox.style.transform = 'scale(0.95)';
                setTimeout(function () {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    targetForm = null;
                }, 150);
            }

            // Event delegation on body for delete trigger buttons
            document.body.addEventListener('click', function (e) {
                var trigger = e.target.closest('[data-delete-trigger]');
                if (trigger) {
                    e.preventDefault();
                    e.stopPropagation();
                    openModal(trigger.getAttribute('data-form-id'), trigger.getAttribute('data-student-name'));
                }
            });

            cancelBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeModal();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });

            confirmBtn.addEventListener('click', function () {
                if (targetForm) targetForm.submit();
            });
        });
    </script>
</x-layouts.dashboard>


<?php

namespace App\Http\Controllers;

use App\Models\PraktikumHistory;
use App\Models\User;
use App\Support\Navigation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PraktikumHistoryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        if ($request->user()?->role !== 'siswa') {
            return response()->json([
                'message' => 'Riwayat hanya bisa disimpan oleh akun siswa.',
            ], 403);
        }

        $data = $request->validate([
            'massa_panas' => ['required', 'numeric', 'min:0.01'],
            'massa_dingin' => ['required', 'numeric', 'min:0.01'],
            'q_lepas' => ['required', 'numeric', 'min:0'],
            'q_terima' => ['required', 'numeric', 'min:0'],
            'delta_q' => ['required', 'numeric', 'min:0'],
            'error_persen' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
            'suhu_panas' => ['nullable', 'numeric'],
            'suhu_dingin' => ['nullable', 'numeric'],
            'suhu_campuran' => ['nullable', 'numeric'],
        ]);

        $history = PraktikumHistory::create([
            ...$data,
            'user_id' => $request->user()->id,
            'kalor_jenis' => 4200,
            'suhu_panas' => $data['suhu_panas'] ?? 70,
            'suhu_dingin' => $data['suhu_dingin'] ?? 28,
            'suhu_campuran' => $data['suhu_campuran'] ?? 45,
        ]);

        return response()->json([
            'message' => 'Riwayat praktikum berhasil disimpan ke database.',
            'history_id' => $history->id,
        ]);
    }

    public function studentHistory(Request $request): View|RedirectResponse
    {
        if ($request->user()?->role !== 'siswa') {
            return redirect()->route('teacher.dashboard');
        }

        $histories = PraktikumHistory::query()
            ->where('user_id', $request->user()?->id)
            ->latest()
            ->get();

        return view('pages.student.history', [
            'items' => Navigation::studentItems(),
            'role' => 'Siswa',
            'histories' => $histories,
        ]);
    }

    public function teacherHistory(Request $request): View|RedirectResponse
    {
        if ($request->user()?->role !== 'guru') {
            return redirect()->route('student.history');
        }

        $students = User::query()
            ->where('role', 'siswa')
            ->latest()
            ->get();

        $classes = $students
            ->pluck('kelas')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $selectedClass = $request->string('kelas')->toString() ?: $classes->first();

        if ($selectedClass && ! $classes->contains($selectedClass)) {
            $selectedClass = $classes->first();
        }

        $allHistories = PraktikumHistory::query()
            ->with(['user', 'grader'])
            ->latest()
            ->get();

        $classSummaries = $classes->map(function (string $className) use ($students, $allHistories): array {
            $classHistories = $allHistories->filter(fn (PraktikumHistory $history): bool => $history->user?->kelas === $className);

            return [
                'name' => $className,
                'students_count' => $students->where('kelas', $className)->count(),
                'histories_count' => $classHistories->count(),
                'graded_count' => $classHistories->whereNotNull('nilai')->count(),
                'pending_count' => $classHistories->whereNull('nilai')->count(),
                'average_score' => $classHistories->whereNotNull('nilai')->avg('nilai'),
            ];
        })->values();

        $histories = PraktikumHistory::query()
            ->with(['user', 'grader'])
            ->when(
                $selectedClass,
                fn ($query) => $query->whereHas('user', fn ($userQuery) => $userQuery->where('kelas', $selectedClass)),
                fn ($query) => $query->whereRaw('1 = 0')
            )
            ->latest()
            ->get();

        return view('pages.teacher.history', [
            'items' => Navigation::teacherItems(),
            'role' => 'Guru',
            'histories' => $histories,
            'classes' => $classes,
            'selectedClass' => $selectedClass,
            'classSummaries' => $classSummaries,
        ]);
    }

    public function grade(Request $request, PraktikumHistory $history)
    {
        if ($request->user()?->role !== 'guru') {
            return redirect()->route('student.praktikum');
        }

        $data = $request->validate([
            'nilai' => ['required', 'integer', 'min:0', 'max:100'],
            'catatan_nilai' => ['nullable', 'string', 'max:1000'],
            'status_penilaian' => ['required', 'in:Lulus,Revisi'],
        ]);

        $history->update([
            'nilai' => $data['nilai'],
            'catatan_nilai' => $data['catatan_nilai'] ?? null,
            'status_penilaian' => $data['status_penilaian'],
            'dinilai_oleh' => $request->user()->id,
            'dinilai_pada' => now(),
        ]);

        return back()->with('success', 'Nilai praktikum berhasil disimpan.');
    }

    public function destroyGrade(Request $request, PraktikumHistory $history)
    {
        if ($request->user()?->role !== 'guru') {
            return redirect()->route('student.praktikum');
        }

        $history->update([
            'nilai' => null,
            'catatan_nilai' => null,
            'status_penilaian' => null,
            'dinilai_oleh' => null,
            'dinilai_pada' => null,
        ]);

        return back()->with('success', 'Nilai praktikum berhasil dihapus.');
    }

    public function destroy(Request $request, PraktikumHistory $history): RedirectResponse
    {
        if ($request->user()?->role !== 'guru') {
            return redirect()->route('student.praktikum');
        }

        $studentName = $history->user?->name ?? 'Siswa';
        $history->delete();

        return back()->with('success', "Riwayat praktikum milik {$studentName} berhasil dihapus.");
    }

    public function exportClassHistory(Request $request)
    {
        if ($request->user()?->role !== 'guru') {
            return redirect()->route('student.history');
        }

        $selectedClass = $request->string('kelas')->toString();

        if (empty($selectedClass)) {
            return back()->withErrors(['export' => 'Pilih kelas terlebih dahulu untuk diekspor.']);
        }

        $histories = PraktikumHistory::query()
            ->with(['user', 'grader'])
            ->whereHas('user', fn ($query) => $query->where('kelas', $selectedClass))
            ->latest()
            ->get();

        if ($histories->isEmpty()) {
            return back()->with('success', "Tidak ada data praktikum untuk kelas $selectedClass yang bisa diexpor.");
        }

        $fileName = 'Penilaian_Praktikum_Kelas_' . str_replace(' ', '_', $selectedClass) . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($histories) {
            $file = fopen('php://output', 'w');
            
            // Excel separator indicator
            fwrite($file, "sep=;\n");

            // CSV Header
            fputcsv($file, [
                'Waktu',
                'Nama Siswa',
                'Email',
                'Kelas',
                'NIS',
                'Massa Panas m1 (kg)',
                'Suhu Panas T1 (C)',
                'Massa Dingin m2 (kg)',
                'Suhu Dingin T2 (C)',
                'Suhu Campuran Tc (C)',
                'Qlepas (J)',
                'Qterima (J)',
                'Error Persen (%)',
                'Status Asas Black',
                'Nilai',
                'Catatan Penilaian',
                'Status Kelulusan',
                'Dinilai Oleh',
                'Dinilai Pada'
            ], ';');

            foreach ($histories as $history) {
                fputcsv($file, [
                    $history->created_at->format('Y-m-d H:i'),
                    $history->user->name,
                    $history->user->email,
                    $history->user->kelas ?? '-',
                    $history->user->nis ?? '-',
                    $history->massa_panas,
                    $history->suhu_panas,
                    $history->massa_dingin,
                    $history->suhu_dingin,
                    $history->suhu_campuran,
                    $history->q_lepas,
                    $history->q_terima,
                    $history->error_persen,
                    $history->status,
                    $history->nilai ?? 'Belum dinilai',
                    $history->catatan_nilai ?? '-',
                    $history->status_penilaian ?? '-',
                    $history->grader?->name ?? '-',
                    $history->dinilai_pada ? $history->dinilai_pada->format('Y-m-d H:i') : '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

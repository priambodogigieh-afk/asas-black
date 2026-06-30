<?php

namespace App\Support;

class Navigation
{
    public static function teacherItems(): array
    {
        return [
            ['label' => 'Dashboard', 'route' => 'teacher.dashboard', 'icon' => 'dashboard'],
            ['label' => 'Data Siswa', 'route' => 'teacher.students', 'icon' => 'group'],
            ['label' => 'Penilaian', 'route' => 'teacher.history', 'icon' => 'rate_review'],
            ['label' => 'Keluar', 'route' => 'login', 'icon' => 'logout'],
        ];
    }

    public static function studentItems(): array
    {
        return [
            ['label' => 'Praktikum', 'route' => 'student.praktikum', 'icon' => 'calculate'],
            ['label' => 'Riwayat', 'route' => 'student.history', 'icon' => 'history'],
            ['label' => 'Keluar', 'route' => 'login', 'icon' => 'logout'],
        ];
    }
}

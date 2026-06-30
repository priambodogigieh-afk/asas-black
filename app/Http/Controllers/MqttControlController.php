<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MqttControlController extends Controller
{
    public function connect(Request $request): JsonResponse
    {
        abort_unless($request->user(), 403);

        $logPath = storage_path('logs/mqtt-subscriber.log');

        if (! is_dir(dirname($logPath))) {
            mkdir(dirname($logPath), 0775, true);
        }

        if ($this->isSubscriberRunning()) {
            return response()->json([
                'message' => 'Subscriber MQTT sudah berjalan di background.',
                'log' => $logPath,
            ]);
        }

        $this->startSubscriber($logPath);

        return response()->json([
            'message' => 'Perintah php artisan mqtt:subscribe sudah dijalankan di background.',
            'log' => $logPath,
        ]);
    }

    private function startSubscriber(string $logPath): void
    {
        $php = env('PHP_PATH', PHP_BINARY);

        // If running under FPM (commonly on production like Railway), fallback to 'php' from PATH
        if (PHP_OS_FAMILY !== 'Windows' && str_contains(strtolower($php), 'fpm')) {
            $php = 'php';
        }

        $artisan = base_path('artisan');

        if (PHP_OS_FAMILY === 'Windows') {
            $command = sprintf(
                'cmd /C start /B "" %s %s mqtt:subscribe >> %s 2>&1',
                escapeshellarg($php),
                escapeshellarg($artisan),
                escapeshellarg($logPath),
            );

            pclose(popen($command, 'r'));

            return;
        }

        $command = sprintf(
            '%s %s mqtt:subscribe >> %s 2>&1 &',
            escapeshellcmd($php),
            escapeshellarg($artisan),
            escapeshellarg($logPath),
        );

        exec($command);
    }

    private function isSubscriberRunning(): bool
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = [];
            exec('wmic process where "Name=\'php.exe\' and CommandLine like \'%mqtt:subscribe%\'" get ProcessId 2>&1', $output);
            $pids = array_filter(array_map('trim', $output), 'is_numeric');
            return count($pids) > 0;
        }

        $output = [];
        exec('pgrep -f "artisan mqtt:subscribe"', $output);
        $pids = array_filter(array_map('trim', $output), 'is_numeric');
        return count($pids) > 0;
    }
}

<?php

namespace App\Console\Commands;

use App\Events\SensorDataUpdated;
use App\Models\SensorReading;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Facades\MQTT;
use Throwable;

class MqttSubscribeCommand extends Command
{
    protected $signature = 'mqtt:subscribe';

    protected $description = 'Subscribe ke topic suhu IoTKita dan simpan data sensor DS18B20 ke database.';

    private const TOPICS = [
        'asasblack/suhu/panas' => 'suhu_panas',
        'asasblack/suhu/dingin' => 'suhu_dingin',
        'asasblack/suhu/campuran' => 'suhu_campuran',
    ];

    public function handle(): int
    {
        $maxRetries = 50;
        $attempt = 0;

        while ($attempt < $maxRetries) {
            $attempt++;
            $this->info("[MQTT] Attempt {$attempt}/{$maxRetries}");

            try {
                $this->connectAndSubscribe();

                // If we get here after loop ends normally, reset attempts
                $attempt = 0;
            } catch (Throwable $throwable) {
                $delay = min(30, pow(2, min($attempt, 5)));

                Log::warning('MQTT subscriber disconnected, retrying...', [
                    'attempt' => $attempt,
                    'delay' => $delay,
                    'error' => $throwable->getMessage(),
                ]);

                $this->warn("[MQTT] Koneksi terputus: {$throwable->getMessage()}");
                $this->info("[MQTT] Retry dalam {$delay} detik...");

                sleep($delay);
            }
        }

        $this->error('[MQTT] Melebihi batas retry. Worker berhenti.');

        return self::FAILURE;
    }

    private function connectAndSubscribe(): void
    {
        $host = (string) config('mqtt-client.connections.default.host');
        $port = (int) config('mqtt-client.connections.default.port');
        $clientId = (string) config('mqtt-client.connections.default.client_id');
        $username = $this->normalizeCredential(config('mqtt-client.connections.default.connection_settings.auth.username'));
        $password = $this->normalizeCredential(config('mqtt-client.connections.default.connection_settings.auth.password'));
        $useTls = (bool) config('mqtt-client.connections.default.connection_settings.tls.enabled');

        $this->info(sprintf('[MQTT] Connecting to %s:%s as %s', $host, $port, $clientId));

        $settings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls($useTls)
            ->setConnectTimeout((int) config('mqtt-client.connections.default.connection_settings.connect_timeout', 60))
            ->setSocketTimeout((int) config('mqtt-client.connections.default.connection_settings.socket_timeout', 5))
            ->setResendTimeout((int) config('mqtt-client.connections.default.connection_settings.resend_timeout', 10))
            ->setKeepAliveInterval((int) config('mqtt-client.connections.default.connection_settings.keep_alive_interval', 10))
            ->setReconnectAutomatically(true)
            ->setMaxReconnectAttempts(10)
            ->setDelayBetweenReconnectAttempts(3);

        $mqtt = MQTT::connection();
        $mqtt->connect($settings, false);

        $this->info('[MQTT] Connected');

        foreach (self::TOPICS as $topic => $column) {
            $mqtt->subscribe($topic, function (string $topic, string $message) use ($column): void {
                $temperature = $this->normalizeTemperature($message);

                if ($temperature === null) {
                    $this->warn("[MQTT] Payload tidak valid pada {$topic}: {$message}");
                    return;
                }

                $latest = SensorReading::query()->latest('id')->first();

                $reading = SensorReading::create([
                    'suhu_panas'    => $column === 'suhu_panas' ? $temperature : $latest?->suhu_panas,
                    'suhu_dingin'   => $column === 'suhu_dingin' ? $temperature : $latest?->suhu_dingin,
                    'suhu_campuran' => $column === 'suhu_campuran' ? $temperature : $latest?->suhu_campuran,
                ]);

                SensorDataUpdated::dispatch($reading);

                $this->line(sprintf('[MQTT] %s : %.2f', $column, $temperature));
            });

            $this->info("[MQTT] Subscribed: {$topic}");
        }

        $mqtt->loop(true);
    }

    private function normalizeCredential(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    private function normalizeTemperature(string $payload): ?float
    {
        $payload = trim($payload);

        if (! is_numeric($payload)) {
            return null;
        }

        return round((float) $payload, 2);
    }
}

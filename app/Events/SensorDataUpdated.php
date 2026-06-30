<?php

namespace App\Events;

use App\Models\SensorReading;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorDataUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly SensorReading $reading) {}

    public function broadcastOn(): Channel
    {
        return new Channel('sensor-data');
    }

    public function broadcastAs(): string
    {
        return 'SensorDataUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'suhu_panas'    => $this->reading->suhu_panas,
            'suhu_dingin'   => $this->reading->suhu_dingin,
            'suhu_campuran' => $this->reading->suhu_campuran,
            'updated_at'    => $this->reading->updated_at?->toISOString(),
        ];
    }
}

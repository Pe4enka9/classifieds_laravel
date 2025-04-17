<?php

namespace App\Events;

use App\Http\Resources\ClassifiedResource;
use App\Models\Classified;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClassifiedCreate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Classified $classified;

    public function __construct($classified)
    {
        $this->classified = $classified;
    }

    public function broadcastWith(): array
    {
        return ['classified' => new ClassifiedResource($this->classified)];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('ads'),
        ];
    }
}

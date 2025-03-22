<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Operation;

class OperationRemoved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Operation $operation;

    /**
     * Create a new event instance.
     */
    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }
}

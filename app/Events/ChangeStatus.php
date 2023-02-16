<?php

namespace App\Events;

use App\Models\App;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public static int $countUserChange = 0;
    public static int $countAppChange = 0;
    public $platform;
    public $app;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct($platform, $app, $user = null)
    {
        $this->platform = $platform;
        $this->app = $app;
        $this->user = $user;
        if(isset($user)) {
            self::$countUserChange ++;
        } else {
            self::$countAppChange ++;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('default'),
        ];
    }
}

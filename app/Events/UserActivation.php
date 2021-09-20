<?php

namespace App\Events;

use App\Models\ActivationCode;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserActivation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $activationCode;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->activationCode = ActivationCode::createCode($user)->code;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

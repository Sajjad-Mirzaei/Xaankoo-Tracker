<?php

namespace App\Listener\UserActivation;

use App\Events\UserActivation;
use App\Mail\ActivationUserAccount;
use App\Models\ActivationCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailListener
{
    public function __construct()
    {
        //
    }

    public function handle(UserActivation $event)
    {
        $user=$event->user;
        $code=$event->activationCode;
        Mail::to($user)->send(new ActivationUserAccount($user,$code));
    }
}

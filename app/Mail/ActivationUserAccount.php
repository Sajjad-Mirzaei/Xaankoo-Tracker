<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationUserAccount extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $code;

    public function __construct(User $user,$code)
    {
        $this->user=$user;
        $this->code=$code;
    }

    public function build()
    {
        return $this->subject('لینک فعالسازی')
            ->markdown('emails.UserActivation',[$this->code]);
    }
}

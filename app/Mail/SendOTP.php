<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOTP extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;

    public function __construct(User $user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Mã OTP Xác Thực - Clothes Store')
                    ->view('emails.otp')  // View emails/otp.blade.php
                    ->with(['user' => $this->user, 'otp' => $this->otp]);
    }
}
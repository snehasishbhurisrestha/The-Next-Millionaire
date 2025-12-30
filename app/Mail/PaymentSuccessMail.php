<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Models\Course;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $course;
    public $transaction;

    public function __construct($user, $course, $transaction)
    {
        $this->user = $user;
        $this->course = $course;
        $this->transaction = $transaction;
    }

    public function build()
    {
        return $this->subject('Welcome to The Next Millionaire – Payment Successful 🎉')
                    ->view('emails.payment_success');
    }
}


<?php

namespace App\Mail;

use App\Models\Expense; // Import model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $expense;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Batas Waktu Pembayaran',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_reminder',
        );
    }
}
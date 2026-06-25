<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $message)
    {}

    public function build()
    {
        return $this->subject($this->message->subject)
            ->view('emails.contact')
            ->with([
                'name' => $this->message->name,
                'email' => $this->message->email,
                'subject' => $this->message->subject,
                'content' => $this->message->message,
            ]);
    }
}

<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $toName;
    public $subjectLine;

    public function __construct($messageContent, $toName, $subjectLine)
    {
        $this->messageContent = $messageContent;
        $this->toName = $toName;
        $this->subjectLine = $subjectLine;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.contact-reply');
                    // use this 
                   
    }
}


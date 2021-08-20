<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuggestionAutoReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $language;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language)
    {
        //
        $this->language = $language;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.suggestionAutoReply')->subject(__('new.suggestion_reply'));
    }
}

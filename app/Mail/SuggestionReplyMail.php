<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SupportModel\Suggestion;

class SuggestionReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $suggestion;
    public $language;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Suggestion $suggestion, $language)
    {
        //
        $this->suggestion = $suggestion;
        $this->language = $language;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.suggestionReply')->subject(__('new.suggestion_reply'));
    }
}

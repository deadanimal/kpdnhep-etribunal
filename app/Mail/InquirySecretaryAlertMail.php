<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\CaseModel\Inquiry;

class InquirySecretaryAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $language;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inquiry $inquiry, $language)
    {
        //
        $this->inquiry = $inquiry;
        $this->language = $language;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.inquirySecretaryAlert')->subject(__('inquiry.sec_alert_subject'));
    }
}

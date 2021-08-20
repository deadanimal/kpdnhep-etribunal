<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\CaseModel\ClaimCase;

class ChangeBranchAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $case;
    public $language;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ClaimCase $case, $language)
    {
        //
        $this->case = $case;
        $this->language = $language;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.changeBranchAlert')->subject(__('new.change_branch_alert'));
    }
}

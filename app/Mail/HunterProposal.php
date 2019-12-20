<?php

namespace App\Mail;

use App\Hunter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HunterProposal extends Mailable
{
    use Queueable, SerializesModels;

    public $hunter;

    /**
     * Create a new message instance.
     *
     * @param $hunter
     */
    public function __construct(Hunter $hunter)
    {
        $this->hunter = $hunter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() : self
    {
        return $this->view('mail.hunter')
            ->to(env('APP_ADMIN_MAIL'))
            ->from('gis@sondehunt.de')
            ->replyTo($this->hunter->proposal_email);
    }
}

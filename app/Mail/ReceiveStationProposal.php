<?php

namespace App\Mail;

use App\ReceiveStation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiveStationProposal extends Mailable
{
    use Queueable, SerializesModels;

    public $receiveStation;

    /**
     * Create a new message instance.
     *
     * @param ReceiveStation $receiveStation
     */
    public function __construct(ReceiveStation $receiveStation)
    {
        $this->receiveStation = $receiveStation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() : self
    {
        return $this->view('mail.receive_station')
            ->to(env('APP_ADMIN_MAIL'))
            ->from('gis@sondehunt.de')
            ->replyTo($this->receiveStation->proposal_email);
    }
}

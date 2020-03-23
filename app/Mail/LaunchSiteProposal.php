<?php

namespace App\Mail;

use App\LaunchSite;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LaunchSiteProposal extends Mailable
{
    use Queueable, SerializesModels;

    public $launchSite;

    /**
     * Create a new message instance.
     *
     * @param LaunchSite $launchSite
     */
    public function __construct(LaunchSite $launchSite)
    {
        $this->launchSite = $launchSite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() : self
    {
        return $this->view('mail.launch_site', ['launch_site' => $this->launchSite])
            ->to(env('APP_ADMIN_MAIL'))
            ->from('gis@sondehunt.de')
            ->replyTo($this->launchSite->proposal_email);
    }
}

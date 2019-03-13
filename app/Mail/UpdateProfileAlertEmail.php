<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class UpdateProfileAlertEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $id;
    public $oldName;
    public $newName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($oldName, $newName, $id)
    {
        $this->oldName = $oldName;
        $this->newName = $newName;
        $this->id = $id;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.update_profile_alert_email');
    }
}

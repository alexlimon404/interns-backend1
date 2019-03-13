<?php

namespace App\Mail;

use App\UserGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddGroupUserAlertEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $group;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserGroup $group)
    {
        $this->group = $group;
        $this->subject($group->name);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.add_group_user_alert_email');
    }
}

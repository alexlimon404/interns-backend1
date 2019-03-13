<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserDataAlertEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $id;
    public $oldName;
    public $newName;
    public $oldRole;
    public $newRole;
    public $banned;
    public $emailAdmin;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($oldDataUser, $user, $admin)
    {
        $this->id = $oldDataUser->id;
        $this->oldName = $oldDataUser->name;
        $this->oldRole = $oldDataUser->role;
        $this->newName = $user->name;
        $this->newRole = $user->role;
        $this->banned = $user->banned;
        $this->emailAdmin =$admin->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.update_user_data_alert_email');
    }
}

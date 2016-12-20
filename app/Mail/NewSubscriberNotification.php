<?php

namespace App\Mail;

use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewSubscriberNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $data = date('d-m-Y  H:i');
        $ip = $_SERVER['REMOTE_ADDR'];

        return $this->from('admin@larablog.com', 'Larablog-Admin')        //per il TESTING --> settare il driver a 'log' in /config/mail.php
                    ->subject('Larablog: nuovo utente registrato')
                    ->view('emails.new_subscriber_notification', compact('data', 'ip'));  // l'array user è passato attraverso il costruttore!
                    
    }
}

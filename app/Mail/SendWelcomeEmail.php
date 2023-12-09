<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * SendWelcomeEmail Mailable class.
 *
 * This class is responsible for creating and configuring a "welcome" email
 * that can be sent to users. The email is queued for sending.
 */
class SendWelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // Data to be passed to the email view
    public $data;

    /**
     * Create a new message instance.
     *
     * @param mixed $data Data to be used in the email view.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Assigning view for the email, passing 'data' to the view
        return $this->view('emails.welcome')->with(['data' => $this->data]);
    }
}

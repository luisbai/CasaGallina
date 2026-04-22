<?php

namespace App\Modules\Donation\Infrastructure\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function build()
    {
        return $this->view('emails.donaciones') // Keeping view path for now
            ->with([
                'input' => $this->input
            ]);
    }
}

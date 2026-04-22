<?php

namespace App\Mail;

use App\Modules\Donation\Infrastructure\Models\Donor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $donor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Donor $donor)
    {
        $this->donor = $donor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('¡Gracias por tu donativo a Casa Gallina!')
            ->view('emails.donation_success');
    }
}

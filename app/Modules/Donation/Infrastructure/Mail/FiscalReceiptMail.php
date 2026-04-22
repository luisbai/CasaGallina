<?php

namespace App\Modules\Donation\Infrastructure\Mail;

use App\Modules\Donation\Infrastructure\Models\Donor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FiscalReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $donador;

    public function __construct(Donor $donor)
    {
        $this->donador = $donor;
    }

    public function build()
    {
        return $this->view('emails.comprobante'); // Keeping view path for now
    }
}

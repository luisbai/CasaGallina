<?php

namespace App\Mail;

use App\Modules\Publication\Infrastructure\Models\Publication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $input;
    public $publicacion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Publication $publicacion, $input)
    {
        $this->input = $input;
        $this->publicacion = $publicacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.lead')
            ->with([
                'input' => $this->input,
                'publicacion' => $this->publicacion
            ]);
    }
}

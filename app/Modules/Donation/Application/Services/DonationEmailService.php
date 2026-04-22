<?php

namespace App\Modules\Donation\Application\Services;

use App\Mail\DonationSuccessMail;
use App\Modules\Donation\Infrastructure\Models\Donor;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DonationEmailService
{
    /**
     * Sends the donation success email to the donor.
     *
     * @param Donor $donor
     * @return void
     */
    public function sendSuccessEmail(Donor $donor): void
    {
        if (!$donor || !$donor->email) {
            Log::warning('DonationEmailService: Tried to send an email to a donor without an email address.', ['donor_id' => $donor->id ?? null]);
            return;
        }

        try {
            Mail::to($donor->email)->send(new DonationSuccessMail($donor));
            Log::info('DonationEmailService: Success email sent.', ['email' => $donor->email]);
        } catch (\Exception $e) {
            Log::error('DonationEmailService: Failed to send success email.', [
                'email' => $donor->email,
                'error' => $e->getMessage()
            ]);
        }
    }
}

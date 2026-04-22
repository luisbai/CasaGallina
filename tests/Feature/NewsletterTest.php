<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail;

class NewsletterTest extends TestCase
{
    /**
     * Test newsletter subscription.
     */
    public function test_newsletter_subscription(): void
    {
        Mail::fake();

        $response = $this->post('/newsletter', [
            'email' => 'test@example.com'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Correo enviado'
        ]);

        Mail::assertSent(NewsletterMail::class, function ($mail) {
            return $mail->email === 'test@example.com';
        });
    }

    /**
     * Test newsletter subscription with invalid email.
     */
    public function test_newsletter_subscription_invalid_email(): void
    {
        $response = $this->post('/newsletter', [
            'email' => 'not-an-email'
        ]);

        $response->assertStatus(302); // Redirect back due to validation error
        $response->assertSessionHasErrors(['email']);
    }
    
    /**
     * Test public newsletter page loads.
     */
    public function test_boletines_page_loads(): void
    {
        $response = $this->get('/boletines');
        $response->assertStatus(200);
    }

    /**
     * Test admin newsletter page loads for authenticated user.
     */
    public function test_admin_newsletter_page_loads(): void
    {
        $user = new \App\Modules\User\Infrastructure\Models\User();
        $user->id = 1;
        
        $response = $this->actingAs($user)->get('/admin/boletines');
        
        $response->assertStatus(200);
    }
}

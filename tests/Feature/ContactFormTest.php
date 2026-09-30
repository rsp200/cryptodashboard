<?php

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

it('shows the contact form', function () {
    $this->get('/contact')->assertOk()->assertSee('Verstuur bericht');
});

it('rejects an empty contact form', function () {
    $this->post('/contact', [])->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
});

it('sends a contact mail when the form is valid', function () {
    Mail::fake();

    $this->post('/contact', [
        'name' => 'Test Persoon',
        'email' => 'test@example.com',
        'subject' => 'Hallo',
        'message' => 'Dit is een testbericht.',
    ])->assertRedirect('/contact')->assertSessionHas('success');

    Mail::assertSent(ContactMail::class, fn (ContactMail $mail) => $mail->hasTo('admin@cryptodashboard.test')
        && $mail->senderEmail === 'test@example.com');
});

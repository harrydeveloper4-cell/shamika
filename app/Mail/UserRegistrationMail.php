<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $role;

    public function __construct(User $user, string $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function envelope(): Envelope
    {
        // $subject = $this->role === 'vendor' 
        //     ? 'Account Created - Pending Approval' 
        //     : 'Welcome! Account Created Successfully';

        $subject = 'Welcome! Account Created Successfully';
        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration',
        );
    }
}
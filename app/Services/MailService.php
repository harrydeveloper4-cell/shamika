<?php

namespace App\Services;

use App\Mail\UserRegistrationMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * Send Registration Email based on User Role.
     */
    public static function sendRegistrationEmail(User $user, string $role): bool
    {
        try {
            Mail::to($user->email)->send(new UserRegistrationMail($user, $role));
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send registration email to {$user->email}: " . $e->getMessage());
            return false;
        }
    }
}
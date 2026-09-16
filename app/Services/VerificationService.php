<?php

namespace App\Services;

use App\Models\Property;
use App\Models\User;
use App\Models\Verification;
use App\Models\Inspection;
use Illuminate\Support\Facades\Gate;

class VerificationService
{
    /**
     * Make a final verification decision for a property.
     *
     * @param Property $property
     * @param User $admin
     * @param string $decision (Verified|Rejected)
     * @param string|null $reason
     * @param Inspection|null $inspection
     * @return Verification
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function makeVerificationDecision(Property $property, User $admin, string $decision, ?string $reason = null, ?Inspection $inspection = null): Verification
    {
        Gate::authorize('make verification decisions');

        $verification = Verification::create([
            'property_id' => $property->id,
            'admin_id' => $admin->id,
            'inspection_id' => $inspection ? $inspection->id : null,
            'verification_status' => $decision,
            'notes' => $reason,
            'verified_at' => ($decision === 'Verified') ? now() : null,
            'rejected_at' => ($decision === 'Rejected') ? now() : null,
            'badge_issued_at' => ($decision === 'Verified') ? now() : null,
        ]);

        $property->update([
            'verification_status' => $decision,
            'is_verified' => ($decision === 'Verified'),
        ]);

        // Additional logic for issuing 'Verified Company Badge' could go here,
        // possibly by updating a field on the Vendor's user model or a separate badge system.

        return $verification;
    }
}

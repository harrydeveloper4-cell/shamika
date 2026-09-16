<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can update the inspection status of the property.
     */
    public function updateInspectionStatus(User $user, Property $property): bool
    {
        return $user->hasRole('property_management_team');
    }

    /**
     * Determine whether the user can update the verification status of the property.
     */
    public function updateVerificationStatus(User $user, Property $property): bool
    {
        return $user->hasRole('admin');
    }
}

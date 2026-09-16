<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\User;
use App\Policies\PropertyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Property::class => PropertyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage users', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage vendors', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage property management team', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage roles', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('view monitoring requests', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('review monitoring requests', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('assign inspections', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('review inspection reports', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('make verification decisions', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('issue verified badge', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage subscriptions', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage commissions', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage vendor payouts', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('view reports', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('view audit logs', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage system configurations', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('operate in vendor mode', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('view dashboard', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('view own properties', function (User $user) {
            return $user->hasRole('vendor') || $user->hasRole('admin');
        });

        Gate::define('create property', function (User $user) {
            return $user->hasRole('vendor') || $user->hasRole('admin');
        });

        Gate::define('edit own property', function (User $user, Property $property) {
            return ($user->hasRole('vendor') && $property->user_id === $user->id) || $user->hasRole('admin');
        });

        Gate::define('archive own property', function (User $user, Property $property) {
            return ($user->hasRole('vendor') && $property->user_id === $user->id) || $user->hasRole('admin');
        });

        Gate::define('submit monitoring request', function (User $user, Property $property) {
            return ($user->hasRole('vendor') && $property->user_id === $user->id) || $user->hasRole('admin');
        });

        Gate::define('view own inspection status', function (User $user) {
            return $user->hasRole('vendor') || $user->hasRole('admin');
        });

        Gate::define('view own verification status', function (User $user) {
            return $user->hasRole('vendor') || $user->hasRole('admin');
        });

        Gate::define('manage own bookings', function (User $user) {
            return $user->hasRole('vendor') || $user->hasRole('admin');
        });

        Gate::define('view own earnings', function (User $user) {
            return $user->hasRole('vendor') || $user->hasRole('admin');
        });

        Gate::define('view own transactions', function (User $user) {
            return $user->hasRole('vendor') || $user->hasRole('admin');
        });

        Gate::define('view own payouts', function (User $user) {
            return $user->hasRole('vendor') || $user->hasRole('admin');
        });

        Gate::define('view assigned inspections', function (User $user, $inspection = null) {
            if (!$user->hasRole('property_management_team')) {
                return false;
            }
            if ($inspection === null) {
                return true;
            }
            return $inspection->inspector_id === $user->id;
        });

        Gate::define('schedule assigned inspection', function (User $user, $inspection = null) {
            if (!$user->hasRole('property_management_team')) {
                return false;
            }
            if ($inspection === null) {
                return true;
            }
            return $inspection->inspector_id === $user->id;
        });

        Gate::define('conduct assigned inspection', function (User $user, $inspection = null) {
            if (!$user->hasRole('property_management_team')) {
                return false;
            }
            if ($inspection === null) {
                return true;
            }
            return $inspection->inspector_id === $user->id;
        });

        Gate::define('upload inspection photos', function (User $user, $inspection = null) {
            if (!$user->hasRole('property_management_team')) {
                return false;
            }
            if ($inspection === null) {
                return true;
            }
            return $inspection->inspector_id === $user->id;
        });

        Gate::define('add inspection notes', function (User $user, $inspection = null) {
            if (!$user->hasRole('property_management_team')) {
                return false;
            }
            if ($inspection === null) {
                return true;
            }
            return $inspection->inspector_id === $user->id;
        });

        Gate::define('submit inspection report', function (User $user, $inspection = null) {
            if (!$user->hasRole('property_management_team')) {
                return false;
            }
            if ($inspection === null) {
                return true;
            }
            return $inspection->inspector_id === $user->id;
        });

        Gate::define('view own activity history', function (User $user) {
            return $user->hasRole('property_management_team');
        });

        Gate::define('search properties', function (User $user = null) {
            return true;
        });

        Gate::define('view property details', function (User $user = null) {
            return true;
        });

        Gate::define('submit viewing request', function (User $user) {
            return $user->hasRole('renter') || $user->hasRole('admin');
        });

        Gate::define('manage own bookings (renter)', function (User $user) {
            return $user->hasRole('renter') || $user->hasRole('admin');
        });

        Gate::define('make payments', function (User $user) {
            return $user->hasRole('renter') || $user->hasRole('admin');
        });

        Gate::define('view own payment history', function (User $user) {
            return $user->hasRole('renter') || $user->hasRole('admin');
        });
    }
}

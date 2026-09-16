<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define Permissions
        $permissions = [
            // Admin Portal
            'manage users',
            'manage vendors',
            'manage property management team',
            'manage roles',
            'view monitoring requests',
            'assign inspections',
            'review inspection reports',
            'make verification decisions',
            'issue verified badge',
            'manage subscriptions',
            'manage commissions',
            'manage vendor payouts',
            'view reports',
            'view audit logs',
            'manage system configurations',
            'operate in vendor mode',
            'view dashboard',

            // Vendor / Property Owner Portal
            'view own properties',
            'create property',
            'edit own property',
            'archive own property',
            'submit monitoring request',
            'view own inspection status',
            'view own verification status',
            'manage own bookings',
            'view own earnings',
            'view own transactions',
            'view own payouts',

            // Property Management Team Portal
            'view assigned inspections',
            'schedule assigned inspection',
            'conduct assigned inspection',
            'upload inspection photos',
            'add inspection notes',
            'submit inspection report',
            'view own activity history',

            // Renter / Tenant Portal
            'search properties',
            'view property details',
            'submit viewing request',
            'manage own bookings (renter)',
            'make payments',
            'view own payment history',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Assign Permissions to Roles
        $adminRole = Role::findByName('admin');
        $propertyManagementTeamRole = Role::findByName('property_management_team');
        $vendorRole = Role::findByName('vendor');
        $renterRole = Role::findByName('renter');

        // Admin has all permissions
        $adminRole->givePermissionTo(Permission::all());

        // Property Management Team permissions
        $propertyManagementTeamRole->givePermissionTo([
            'view assigned inspections',
            'schedule assigned inspection',
            'conduct assigned inspection',
            'upload inspection photos',
            'add inspection notes',
            'submit inspection report',
            'view own activity history',
        ]);

        // Vendor permissions
        $vendorRole->givePermissionTo([
            'view own properties',
            'create property',
            'edit own property',
            'archive own property',
            'submit monitoring request',
            'view own inspection status',
            'view own verification status',
            'manage own bookings',
            'view own earnings',
            'view own transactions',
            'view own payouts',
        ]);

        // Renter permissions
        $renterRole->givePermissionTo([
            'search properties',
            'view property details',
            'submit viewing request',
            'manage own bookings (renter)',
            'make payments',
            'view own payment history',
        ]);
    }
}

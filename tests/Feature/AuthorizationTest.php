<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions
        $this->artisan('db:seed --class=RoleSeeder');
        $this->artisan('db:seed --class=PermissionSeeder');

        // Create users with specific roles
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->propertyManagementTeam = User::factory()->create();
        $this->propertyManagementTeam->assignRole('property_management_team');

        $this->vendor = User::factory()->create();
        $this->vendor->assignRole('vendor');

        $this->renter = User::factory()->create();
        $this->renter->assignRole('renter');

        // Create another vendor for property ownership tests
        $this->anotherVendor = User::factory()->create();
        $this->anotherVendor->assignRole('vendor');
    }

    /** @test */
    public function property_management_team_cannot_set_verification_status()
    {
        $property = Property::factory()->for($this->vendor)->create();

        $this->actingAs($this->propertyManagementTeam);

        $response = $this->put('/admin/verifications/' . $property->id . '/decide', [
            'decision' => 'Verified',
        ]);

        $response->assertNotFound();
    }

    /** @test */
    public function only_admin_can_issue_verified_badge()
    {
        $property = Property::factory()->for($this->vendor)->create();

        // Test as Property Management Team
        $this->actingAs($this->propertyManagementTeam);
        $response = $this->put('/admin/verifications/' . $property->id . '/decide', [
            'decision' => 'Verified',
        ]);
        $response->assertForbidden();

        // Test as Vendor
        $this->actingAs($this->vendor);
        $response = $this->put('/admin/verifications/' . $property->id . '/decide', [
            'decision' => 'Verified',
        ]);
        $response->assertForbidden();

        // Test as Renter
        $this->actingAs($this->renter);
        $response = $this->put('/admin/verifications/' . $property->id . '/decide', [
            'decision' => 'Verified',
        ]);
        $response->assertForbidden();

        // Test as Admin
        $this->actingAs($this->admin);
        $response = $this->put('/admin/verifications/' . $property->id . '/decide', [
            'decision' => 'Verified',
        ]);
        $response->assertRedirect(); // Should redirect on success
        $this->assertTrue($property->fresh()->is_verified);
        $this->assertEquals('Verified', $property->fresh()->verification_status);
    }

    /** @test */
    public function vendor_cannot_edit_another_vendors_property()
    {
        $property = Property::factory()->for($this->anotherVendor)->create();

        $this->actingAs($this->vendor);

        $response = $this->put('/vendor/properties/' . $property->id, [
            'title' => 'Attempted change',
            'description' => 'Attempted change',
            'address' => 'Attempted change',
            'city' => 'Attempted change',
            'state' => 'Attempted change',
            'zip_code' => '12345',
            'country' => 'USA',
            'price' => 100000,
            'type' => 'house',
            'purpose' => 'sell',
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function renter_cannot_access_admin_routes()
    {
        $this->actingAs($this->renter);

        // Attempt to access an admin route
        $response = $this->get('/admin/dashboard');
        $response->assertForbidden();

        $response = $this->get('/admin/users');
        $response->assertForbidden();
    }
}

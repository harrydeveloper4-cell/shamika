<?php

namespace App\Services;

use App\Models\Inspection;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class InspectionService
{
    /**
     * Assign an inspection to a property management team member.
     *
     * @param Property $property
     * @param User $inspector
     * @return Inspection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function assignInspection(Property $property, User $inspector): Inspection
    {
        // Only Admin can assign inspections, this will be checked via policy on MonitoringRequest for assigning inspections.
        // Here, we assume the check has passed.

        // Create the inspection record
        $inspection = Inspection::create([
            'property_id' => $property->id,
            'inspector_id' => $inspector->id,
            'status' => 'Assigned',
        ]);

        // Update property inspection status if necessary
        if ($property->inspection_status === 'Assigned') {
             $property->update(['inspection_status' => 'Assigned']);
        }
       
        return $inspection;
    }

    /**
     * Schedule an inspection.
     *
     * @param Inspection $inspection
     * @param string $scheduledAt
     * @return Inspection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function scheduleInspection(Inspection $inspection, string $scheduledAt): Inspection
    {
        Gate::authorize('updateInspectionStatus', $inspection->property);

        $inspection->update([
            'scheduled_at' => $scheduledAt,
            'status' => 'Scheduled',
        ]);

        $inspection->property->update(['inspection_status' => 'Scheduled']);

        return $inspection;
    }

    /**
     * Conduct an inspection.
     *
     * @param Inspection $inspection
     * @param string $notes
     * @param array $photos (optional)
     * @param array $documents (optional)
     * @return Inspection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function conductInspection(Inspection $inspection, string $notes, array $photos = [], array $documents = []): Inspection
    {
        Gate::authorize('updateInspectionStatus', $inspection->property);

        // In a real application, you would handle file uploads here.
        // For now, just update notes and status.
        $inspection->update([
            'notes' => $notes,
            'status' => 'In Progress',
        ]);

        $inspection->property->update(['inspection_status' => 'In Progress']);

        return $inspection;
    }

    /**
     * Submit an inspection report with a recommendation.
     *
     * @param Inspection $inspection
     * @param string $recommendation (approve|reject)
     * @return Inspection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function submitReport(Inspection $inspection, string $recommendation): Inspection
    {
        Gate::authorize('updateInspectionStatus', $inspection->property);

        $inspection->update([
            'recommendation' => $recommendation,
            'status' => 'Report Submitted',
            'completed_at' => now(),
            'report_submitted_at' => now(),
        ]);

        $inspection->property->update(['inspection_status' => 'Report Submitted']);

        return $inspection;
    }
}

<?php

namespace App\Services;

class FacilityLevelService
{
    /**
     * Determine the facility level based on staff count, beds, and services.
     * 
     * @param array $data Facility data including staff counts and services.
     * @return int Level ID (1: Primary, 2: Secondary, 3: Tertiary)
     */
    public function determineLevel(array $data): int
    {
        $doctors = (int)($data['doctors'] ?? 0);
        $beds = (int)($data['beds'] ?? 0);
        $hasSpecializedServices = $this->checkSpecializedServices($data);

        // Tertiary Level Criteria:
        // - Large number of doctors (> 20)
        // - High bed capacity (> 100)
        // - Has specialized services like Imaging or Mortuary
        if ($doctors >= 20 && $beds >= 100 && $hasSpecializedServices) {
            return 3; // Tertiary
        }

        // Secondary Level Criteria:
        // - Moderate doctors (5-19)
        // - Moderate bed capacity (30-99)
        // - Basic specialized services
        if ($doctors >= 5 && $beds >= 30) {
            return 2; // Secondary
        }

        // Primary Level Criteria:
        // - Small staff
        // - Low bed capacity
        return 1; // Primary
    }

    /**
     * Check if specialized services are present.
     */
    private function checkSpecializedServices(array $data): bool
    {
        $specializedFields = [
            'onsite_imaging',
            'onsite_laboratory',
            'mortuary_services',
            'ambulance',
            'ambulance_services'
        ];

        foreach ($specializedFields as $field) {
            if (isset($data[$field]) && ($data[$field] === 'Yes' || $data[$field] == 1)) {
                return true;
            }
        }

        return false;
    }
}

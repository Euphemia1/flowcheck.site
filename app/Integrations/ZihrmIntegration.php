<?php

namespace App\Integrations;

class ZihrmIntegration
{
    public function __construct(private ?string $apiUrl = null, private ?string $apiKey = null) {}

    public function getDepartments(): array
    {
        // Stub: sync departments from Zambia IHRM when configured
        return [];
    }

    public function getEmployees(): array
    {
        // Stub: sync users/approvers from IHRM
        return [];
    }
}

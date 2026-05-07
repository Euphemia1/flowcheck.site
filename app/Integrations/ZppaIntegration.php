<?php

namespace App\Integrations;

class ZppaIntegration
{
    public function __construct(private ?string $apiKey = null) {}

    public function verifyVendor(string $zppaRegNumber): array
    {
        // Stub: replace with real ZPPA e-GP API call when available
        return [
            'verified'    => false,
            'message'     => 'ZPPA API integration not yet configured.',
            'reg_number'  => $zppaRegNumber,
        ];
    }

    public function submitProcurementNotice(array $data): array
    {
        return [
            'submitted' => false,
            'message'   => 'ZPPA e-GP submission not yet configured.',
        ];
    }
}

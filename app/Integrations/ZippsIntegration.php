<?php

namespace App\Integrations;

class ZippsIntegration
{
    public function __construct(private ?string $apiUrl = null, private ?string $apiKey = null) {}

    public function postPayment(array $data): array
    {
        // Stub: post approved invoice to ZIPPS payment portal
        return [
            'posted'  => false,
            'message' => 'ZIPPS integration not yet configured.',
        ];
    }

    public function getPaymentStatus(string $reference): array
    {
        return [
            'status'  => 'unknown',
            'message' => 'ZIPPS integration not yet configured.',
        ];
    }
}

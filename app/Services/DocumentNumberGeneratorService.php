<?php

namespace App\Services;

use App\Models\DocumentSequence;
use App\Models\Organisation;

class DocumentNumberGeneratorService
{
    public function generatePrNumber(Organisation $organisation): string
    {
        return $this->generate($organisation, 'pr_sequence', 'PR');
    }

    public function generatePoNumber(Organisation $organisation): string
    {
        return $this->generate($organisation, 'po_sequence', 'PO');
    }

    public function generateRfqNumber(Organisation $organisation): string
    {
        return $this->generate($organisation, 'rfq_sequence', 'RFQ');
    }

    public function generateGrnNumber(Organisation $organisation): string
    {
        return $this->generate($organisation, 'grn_sequence', 'GRN');
    }

    public function generateInvoiceNumber(Organisation $organisation): string
    {
        return $this->generate($organisation, 'invoice_sequence', 'INV');
    }

    public function generateBoqNumber(Organisation $organisation): string
    {
        return $this->generate($organisation, 'boq_sequence', 'BOQ');
    }

    public function generateTenderNumber(Organisation $organisation): string
    {
        return $this->generate($organisation, 'tender_sequence', 'TND');
    }

    public function generateContractNumber(Organisation $organisation): string
    {
        return $this->generate($organisation, 'contract_sequence', 'CTR');
    }

    private function generate(Organisation $organisation, string $column, string $prefix): string
    {
        $seq = DocumentSequence::firstOrCreate(
            ['organisation_id' => $organisation->id],
            ['pr_sequence' => 1]
        );

        $sequence = $seq->increment($column);
        $year = now()->year;
        
        return sprintf('%s-%d-%05d', $prefix, $year, $seq->{$column});
    }
}

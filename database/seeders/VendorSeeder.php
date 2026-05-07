<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organisation::where('slug', 'corelink-construction')->first();
        if (!$org) return;

        $vendors = [
            ['name' => 'Lusaka Building Supplies Ltd',   'email' => 'info@lusaka-bs.co.zm',    'contact_person' => 'Patrick Banda',   'phone' => '+260977100001', 'tax_pin' => '1234567890', 'payment_terms' => 'Net 30', 'zppa_reg' => 'ZPPA-2023-00123', 'zppa_class' => 'Class A'],
            ['name' => 'Zamsteel Hardware Ltd',          'email' => 'orders@zamsteel.co.zm',   'contact_person' => 'Grace Mwale',     'phone' => '+260977100002', 'tax_pin' => '9876543210', 'payment_terms' => 'Net 45', 'zppa_reg' => 'ZPPA-2023-00456', 'zppa_class' => 'Class B'],
            ['name' => 'CopperConstruct Materials',      'email' => 'sales@copperconstruct.zm', 'contact_person' => 'David Zulu',      'phone' => '+260977100003', 'tax_pin' => '1122334455', 'payment_terms' => 'Net 30', 'zppa_reg' => 'ZPPA-2023-00789', 'zppa_class' => 'Class A'],
            ['name' => 'African Electricals Zambia',     'email' => 'info@africanelec.co.zm',  'contact_person' => 'Mary Phiri',      'phone' => '+260977100004', 'tax_pin' => '5544332211', 'payment_terms' => 'Net 60', 'zppa_reg' => 'ZPPA-2022-01234', 'zppa_class' => 'Class C'],
            ['name' => 'Ndola Civil Engineering Co.',    'email' => 'civil@ndolace.co.zm',     'contact_person' => 'James Mukuka',    'phone' => '+260977100005', 'tax_pin' => '6677889900', 'payment_terms' => 'Net 30', 'zppa_reg' => 'ZPPA-2023-01567', 'zppa_class' => 'Class A'],
        ];

        foreach ($vendors as $v) {
            Vendor::firstOrCreate(['organisation_id' => $org->id, 'email' => $v['email']], [
                'id'               => Str::uuid(),
                'organisation_id'  => $org->id,
                'name'             => $v['name'],
                'contact_person'   => $v['contact_person'],
                'email'            => $v['email'],
                'phone'            => $v['phone'],
                'address'          => 'Lusaka, Zambia',
                'tax_pin'          => $v['tax_pin'],
                'payment_terms'    => $v['payment_terms'],
                'is_approved'      => true,
                'performance_score'=> 4.2,
                'bank_details'     => ['bank' => 'Zanaco', 'account' => '0001234567', 'branch' => 'Lusaka Main'],
                'zppa_reg_number'  => $v['zppa_reg'] ?? null,
                'zppa_reg_class'   => $v['zppa_class'] ?? null,
            ]);
        }
    }
}

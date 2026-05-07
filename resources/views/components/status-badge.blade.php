@php
$map = [
    'draft'              => 'bg-gray-100 text-gray-600',
    'submitted'          => 'bg-amber-50 text-amber-700',
    'pending'            => 'bg-amber-50 text-amber-700',
    'pending_matching'   => 'bg-amber-50 text-amber-700',
    'under_review'       => 'bg-blue-50 text-blue-700',
    'sent'               => 'bg-blue-50 text-blue-700',
    'acknowledged'       => 'bg-blue-50 text-blue-700',
    'approved'           => 'bg-green-50 text-green-700',
    'matched'            => 'bg-green-50 text-green-700',
    'received'           => 'bg-green-50 text-green-700',
    'partially_received' => 'bg-amber-50 text-amber-700',
    'active'             => 'bg-green-50 text-green-700',
    'published'          => 'bg-green-50 text-green-700',
    'awarded'            => 'bg-green-50 text-green-700',
    'rejected'           => 'bg-red-50 text-red-700',
    'failed'             => 'bg-red-50 text-red-700',
    'discrepancy'        => 'bg-red-50 text-red-700',
    'cancelled'          => 'bg-gray-100 text-gray-500',
    'closed'             => 'bg-gray-100 text-gray-500',
    'expired'            => 'bg-red-50 text-red-700',
    'expiring_soon'      => 'bg-amber-50 text-amber-700',
    'approved_for_payment'=> 'bg-green-50 text-green-700',
];
$cls = $map[$status ?? ''] ?? 'bg-gray-100 text-gray-600';
@endphp
<span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $cls }}">
    {{ ucwords(str_replace('_', ' ', $status ?? 'unknown')) }}
</span>

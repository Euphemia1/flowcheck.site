<?php

namespace App\Notifications;

use App\Models\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseOrderCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public PurchaseOrder $po) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Purchase Order Created: {$this->po->po_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("A purchase order has been created.")
            ->line("PO: **{$this->po->po_number}** — Vendor: {$this->po->vendor->name}")
            ->line("Amount: ZMW " . number_format($this->po->total_amount, 2))
            ->action('View Purchase Order', route('app.purchase-orders.show', $this->po));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => "Purchase order {$this->po->po_number} created for {$this->po->vendor->name}.",
            'url'      => route('app.purchase-orders.show', $this->po),
            'model'    => 'PurchaseOrder',
            'model_id' => $this->po->id,
        ];
    }
}

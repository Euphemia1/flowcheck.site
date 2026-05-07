<?php

namespace App\Notifications;

use App\Models\GoodsReceivedNote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GrnCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public GoodsReceivedNote $grn) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("GRN Created: {$this->grn->grn_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Goods have been received against PO {$this->grn->purchaseOrder->po_number}.")
            ->line("GRN: **{$this->grn->grn_number}**")
            ->action('View GRN', route('app.grns.show', $this->grn));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => "GRN {$this->grn->grn_number} created for PO {$this->grn->purchaseOrder->po_number}.",
            'url'      => route('app.grns.show', $this->grn),
            'model'    => 'GoodsReceivedNote',
            'model_id' => $this->grn->id,
        ];
    }
}

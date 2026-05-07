<?php

namespace App\Notifications;

use App\Models\PurchaseRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseRequestSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public PurchaseRequest $pr) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New Purchase Request: {$this->pr->pr_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("A new purchase request has been submitted and requires your approval.")
            ->line("PR: **{$this->pr->pr_number}** — {$this->pr->title}")
            ->line("Amount: ZMW " . number_format($this->pr->total_amount, 2))
            ->action('Review Request', route('app.purchase-requests.show', $this->pr))
            ->line('This request is pending your action.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => "Purchase request {$this->pr->pr_number} submitted for approval.",
            'url'      => route('app.purchase-requests.show', $this->pr),
            'model'    => 'PurchaseRequest',
            'model_id' => $this->pr->id,
        ];
    }
}

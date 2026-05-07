<?php

namespace App\Notifications;

use App\Models\PurchaseRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseRequestApproved extends Notification implements ShouldQueue
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
            ->subject("PR Approved: {$this->pr->pr_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your purchase request has been approved.")
            ->line("PR: **{$this->pr->pr_number}** — {$this->pr->title}")
            ->action('View Request', route('app.purchase-requests.show', $this->pr));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => "Your purchase request {$this->pr->pr_number} has been approved.",
            'url'      => route('app.purchase-requests.show', $this->pr),
            'model'    => 'PurchaseRequest',
            'model_id' => $this->pr->id,
        ];
    }
}

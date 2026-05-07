<?php

namespace App\Notifications;

use App\Models\PurchaseRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseRequestRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public PurchaseRequest $pr, public ?string $reason = null) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject("PR Rejected: {$this->pr->pr_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your purchase request has been rejected.")
            ->line("PR: **{$this->pr->pr_number}** — {$this->pr->title}");

        if ($this->reason) {
            $mail->line("Reason: {$this->reason}");
        }

        return $mail->action('View Request', route('app.purchase-requests.show', $this->pr));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => "Your purchase request {$this->pr->pr_number} has been rejected." . ($this->reason ? " Reason: {$this->reason}" : ''),
            'url'      => route('app.purchase-requests.show', $this->pr),
            'model'    => 'PurchaseRequest',
            'model_id' => $this->pr->id,
        ];
    }
}

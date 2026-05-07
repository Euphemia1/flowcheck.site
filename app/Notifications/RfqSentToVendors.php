<?php

namespace App\Notifications;

use App\Models\Rfq;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RfqSentToVendors extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Rfq $rfq) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("RFQ Issued: {$this->rfq->rfq_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("An RFQ has been issued to vendors.")
            ->line("RFQ: **{$this->rfq->rfq_number}** — {$this->rfq->title}")
            ->line("Deadline: " . \Carbon\Carbon::parse($this->rfq->deadline)->toFormattedDateString())
            ->action('View RFQ', route('app.rfqs.show', $this->rfq));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => "RFQ {$this->rfq->rfq_number} sent to vendors. Deadline: " . \Carbon\Carbon::parse($this->rfq->deadline)->toDateString(),
            'url'      => route('app.rfqs.show', $this->rfq),
            'model'    => 'Rfq',
            'model_id' => $this->rfq->id,
        ];
    }
}

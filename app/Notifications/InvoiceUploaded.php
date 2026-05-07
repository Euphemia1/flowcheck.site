<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceUploaded extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Invoice $invoice) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Invoice Uploaded: {$this->invoice->invoice_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("An invoice has been uploaded and is pending review.")
            ->line("Invoice: **{$this->invoice->invoice_number}** — ZMW " . number_format($this->invoice->amount, 2))
            ->action('Review Invoice', route('app.invoices.show', $this->invoice));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => "Invoice {$this->invoice->invoice_number} uploaded — ZMW " . number_format($this->invoice->amount, 2) . ".",
            'url'      => route('app.invoices.show', $this->invoice),
            'model'    => 'Invoice',
            'model_id' => $this->invoice->id,
        ];
    }
}

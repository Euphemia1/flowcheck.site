<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceApproved extends Notification implements ShouldQueue
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
            ->subject("Invoice Approved: {$this->invoice->invoice_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Invoice **{$this->invoice->invoice_number}** has been approved for payment.")
            ->line("Amount: ZMW " . number_format($this->invoice->amount, 2))
            ->action('View Invoice', route('app.invoices.show', $this->invoice));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => "Invoice {$this->invoice->invoice_number} approved for payment.",
            'url'      => route('app.invoices.show', $this->invoice),
            'model'    => 'Invoice',
            'model_id' => $this->invoice->id,
        ];
    }
}

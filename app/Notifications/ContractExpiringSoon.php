<?php

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractExpiringSoon extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Contract $contract, public int $daysLeft) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Contract Expiring Soon: {$this->contract->contract_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Contract **{$this->contract->contract_number}** expires in {$this->daysLeft} days.")
            ->line("Vendor: {$this->contract->vendor->name}")
            ->line("Expiry: " . \Carbon\Carbon::parse($this->contract->end_date)->toFormattedDateString())
            ->action('View Contract', route('app.contracts.show', $this->contract));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => "Contract {$this->contract->contract_number} expires in {$this->daysLeft} days.",
            'url'      => route('app.contracts.show', $this->contract),
            'model'    => 'Contract',
            'model_id' => $this->contract->id,
        ];
    }
}

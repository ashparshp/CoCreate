<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountStatusNotification extends Notification
{
    // Removed ShouldQueue interface and Queueable trait to prevent queuing
    
    protected $isActive;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(bool $isActive, ?string $reason = null)
    {
        $this->isActive = $isActive;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if ($this->isActive) {
            return (new MailMessage)
                ->subject('Your Account Has Been Activated')
                ->greeting('Hello ' . $notifiable->name . ',')
                ->line('Good news! Your account has been activated by an administrator.')
                ->line('You can now log in and access all features of our platform.')
                ->action('Log In Now', url('/login'))
                ->line('Thank you for using our application!');
        } else {
            return (new MailMessage)
                ->subject('Your Account Has Been Deactivated')
                ->greeting('Hello ' . $notifiable->name . ',')
                ->line('We regret to inform you that your account has been deactivated by an administrator.')
                ->when($this->reason, function ($message) {
                    return $message->line('Reason: ' . $this->reason);
                })
                ->line('If you believe this is an error or would like to appeal this decision, please contact our support team.')
                ->line('Thank you for your understanding.');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'is_active' => $this->isActive,
            'reason' => $this->reason,
        ];
    }
}
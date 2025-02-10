<?php

namespace App\Notifications;

use App\Models\TeamInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamInvitationNotification extends Notification
{
    use Queueable;

    protected $invitation;

    public function __construct(TeamInvitation $invitation)
    {
        $this->invitation = $invitation;
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
    public function toMail($notifiable)
    {
        $acceptUrl = url("/api/teams/accept-invitation?token=" . $this->invitation->token);
        $registerUrl = url("/register");

        return (new MailMessage)
            ->subject('You have been invited to join a team!')
            ->greeting('Hello!')
            ->line('You have been invited to join the team: ' . $this->invitation->team->name)
            ->action('Accept Invitation', $acceptUrl)
            ->line('If you don’t have an account, please register first.')
            ->action('Register Here', $registerUrl)
            ->line('If you did not expect this invitation, you can ignore this email.');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

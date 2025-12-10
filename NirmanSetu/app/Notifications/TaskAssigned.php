<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    /**
     * Create a new notification instance.
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Store in DB.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'A new task "' . $this->task->title . '" has been assigned to you.',
            'task_id' => $this->task->id,
        ];
    }

    /**
     * Broadcast for real-time.
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'A new task "' . $this->task->title . '" has been assigned to you.',
            'task_id' => $this->task->id,
        ]);
    }

    /**
     * Optional: Send email if needed.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Task Assigned')
            ->line('A new task "' . $this->task->title . '" has been assigned.')
            ->action('View Task', url('/tasks/' . $this->task->id));
    }
}
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceAdded extends Notification
{
    use Queueable;

    private $invoice_id;
    private $invoice_number;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice_id, $invoice_number, $user)
    {
        $this->invoice_id       = $invoice_id;
        $this->invoice_number   = $invoice_number;
        $this->user             = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }


    public function toDatabase($notifiable)
    {
        return [
            'id' =>     $this->invoice_id,
            'title' =>  'Invoice number \'' . $this->invoice_number . '\' has been added ' . 'by ' . $this->user,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

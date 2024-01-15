<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    public $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $address = $this->order->billingAddress;
        return (new MailMessage)
                    ->subject("New Order #{$this->order->number}")
                    ->from('Notification@store.ps','Store')
                    ->greeting("Hi $notifiable->name")
                    ->line("A New Order #({$this->order->number}) created by. $address->name from {$address->countryname}.")
                    ->action('View Order', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }



    public function toDatabase($notifiable)
    {
        $address = $this->order->billingAddress;
        return [
            'body' => "A New Order #({$this->order->number}) created by. $address->name from {$address->countryname}.",
            'icon' => 'fas fa-file',
            'url'  =>  url('/dashboard'),
            'order_id' => $this->order->id,
        ];
    }



    public function toBroadcast($notifiable)
    {
        $address = $this->order->billingAddress;
        return new BroadcastMessage([
            'body' => "A New Order #({$this->order->number}) created by. $address->name from {$address->countryname}.",
            'icon' => 'fas fa-file',
            'url'  =>  url('/dashboard'),
            'order_id' => $this->order->id,
        ]);
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

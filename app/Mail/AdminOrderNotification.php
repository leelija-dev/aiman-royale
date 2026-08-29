<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customerName;

    public function __construct($order, $customerName)
    {
        $this->order = $order;
        $this->customerName = $customerName;
    }

    public function build()
    {
        return $this->subject('New Order #' . $this->order->id . ' - Admin Notification')
                    ->view('emails.admin-order-notification')
                    ->with([
                        'order' => $this->order,
                        'customerName' => $this->customerName
                    ]);
    }
}
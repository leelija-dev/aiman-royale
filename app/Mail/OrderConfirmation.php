<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
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
        return $this->subject('Order Confirm #' . $this->order->id)
                    ->view('emails.order-confirmation')
                    ->with([
                        'order' => $this->order,
                        'customerName' => $this->customerName
                    ]);
    }
}
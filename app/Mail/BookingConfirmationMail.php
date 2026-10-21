<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $patient;
    public $timeSlot;
    public $setting;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $patient, $timeSlot = null, $setting = null)
    {
        $this->order = $order;
        $this->patient = $patient;
        $this->timeSlot = $timeSlot;
        $this->setting = $setting;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $patientName = $this->patient ? ($this->patient->first_name . ' ' . ($this->patient->last_name ?? '')) : 'New Patient';
        $bookingDate = $this->order->booking_date ? \Carbon\Carbon::parse($this->order->booking_date)->format('d M Y') : 'N/A';

        return $this->subject("[New Appointment] {$patientName} - {$bookingDate} (Order #{$this->order->id})")
                    ->view('emails.booking_confirmation');
    }
}

<?php

namespace App\Mail;

use App\Models\ContactRent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContactRentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactRent;

    public function __construct(ContactRent $contactRent)
    {
        $this->contactRent = $contactRent;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'))
                    ->subject('Yeni Kiraye Telebi')
                    ->html("
                        <h2>Yeni Kiraye Telebi</h2>
                        <p><strong>Ad:</strong> {$this->contactRent->name}</p>
                        <p><strong>Marka Adı:</strong> {$this->contactRent->brand_name}</p>
                        <p><strong>E-mail:</strong> {$this->contactRent->email}</p>
                        <p><strong>Telefon:</strong> {$this->contactRent->phone_prefix} {$this->contactRent->phone_number}</p>
                        <p><strong>Depo:</strong> {$this->contactRent->warehouse}</p>
                        <p><strong>Istenilen erazi:</strong> {$this->contactRent->requested_area}</p>
                        <p><strong>Mesaj:</strong> {$this->contactRent->message}</p>
                        <p><strong>Tarix:</strong> " . now()->format('d.m.Y H:i:s') . "</p>
                    ");
    }
} 
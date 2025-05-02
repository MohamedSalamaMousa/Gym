<?php

namespace App\Services;

use Twilio\Rest\Client;


class WhatsAppService
{
    protected $client;

    public function __construct()
    {
        $sid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $this->client = new Client($sid, $authToken);
    }

    public function sendWelcomeMessage($to, $message, $imageUrl)
    {
        // Send the message with image URL
        return $this->client->messages->create(
            "whatsapp:$to", // Recipient's WhatsApp number
            [
                'from' => env('TWILIO_WHATSAPP_FROM'), // Your Twilio WhatsApp number
                'body' => $message, // Message text
                'mediaUrl' => $imageUrl // Barcode image URL
            ]
        );
    }
}
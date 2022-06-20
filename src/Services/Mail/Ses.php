<?php

declare(strict_types=1);

namespace App\Services\Mail;

use App\Services\Aws\Factory;

final class Ses extends Base
{
    protected $client;

    public function __construct()
    {
        $this->client = Factory::createSes();
    }

    public function getSender()
    {
        return $_ENV['aws_ses_sender'];
    }

    public function send($to, $subject, $text): void
    {
        $this->client->sendEmail([
            'Destination' => [ // REQUIRED
                'ToAddresses' => [$to],
            ],
            'Message' => [ // REQUIRED
                'Body' => [ // REQUIRED
                    'Html' => [
                        'Data' => $text, // REQUIRED
                    ],
                    'Text' => [
                        'Data' => $text, // REQUIRED
                    ],
                ],
                'Subject' => [ // REQUIRED
                    'Data' => $subject, // REQUIRED
                ],
            ],
            'Source' => $this->getSender(), // REQUIRED
        ]);
    }
}

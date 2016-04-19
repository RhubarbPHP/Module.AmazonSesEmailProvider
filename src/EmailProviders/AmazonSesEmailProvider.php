<?php

namespace Rhubarb\AmazonSesEmail\EmailProviders;

use Aws\Sdk;
use Rhubarb\AmazonSesEmail\Settings\AmazonSesSettings;
use Rhubarb\Crown\Exceptions\EmailException;
use Rhubarb\Crown\Exceptions\SettingMissingException;
use Rhubarb\Crown\Sendables\Email\Email;
use Rhubarb\Crown\Sendables\Email\EmailProvider;
use Rhubarb\Crown\Sendables\Sendable;

class AmazonSesEmailProvider extends EmailProvider
{
    const MAX_ATTACHMENT_NAME_LENGTH = 60;

    public function send(Sendable $sendable)
    {
        $settings = AmazonSesSettings::singleton();

        /**
         * @var Email $email
         */
        $email = $sendable;

        $sdk = new Sdk([
            'region' => $settings->region,
            'version' => $settings->version,
        ]);

        $client = $sdk->createSes();

        foreach ($email->getRecipients() as $recipient) {
            try {
                $client->sendEmail($this->createEmailPayload($email, $recipient));
            } catch (\Exception $er) {
                throw new EmailException($er->getMessage(), $er);
            }
        }
    }

    private function createEmailPayload(Email $email, $recipient)
    {
        $sesEmailPayload = [
            'Destinations' => [
                $recipient->email
            ],
            'RawMessage' => [
                'Data' => $email->getBodyRaw()
            ],
            'Source' => [
                $email->getSender()->email
            ]
        ];

        return $sesEmailPayload;
    }
}

<?php

namespace Rhubarb\AmazonSesEmail\Settings;

use Rhubarb\Crown\Settings;

/**
 * Settings for the AmazonSesEmailProvider
 */
class AmazonSesSettings extends Settings
{
    /**
     * @var string
     */
    public $region = "";
    /**
     * @var string
     */
    public $version = 'latest';

    //  AWS Key & Secret Key can be accessed via the below guide:
    //  http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/credentials.html#credential-profiles
}

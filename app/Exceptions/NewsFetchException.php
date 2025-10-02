<?php

namespace App\Exceptions;

use Exception;

class NewsFetchException extends Exception
{
    public static function providerFailed(string $providerName, ?string $message = null)
    {
        return new self("Fetching news from {$providerName} failed: {$message}");
    }
}

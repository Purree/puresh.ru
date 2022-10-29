<?php

namespace App\Helpers\Files;

enum FileDrivers: string
{
    case public = 'public';

    public static function getDriver(): string
    {
        return self::public->value;
    }
}

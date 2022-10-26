<?php

namespace App\Helpers\Files;

enum FileDrivers: string
{
    case public = 'public';

    public static function getDisk(): string
    {
        return self::public->value;
    }
}

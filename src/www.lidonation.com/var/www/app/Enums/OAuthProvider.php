<?php

namespace App\Enums;

enum OAuthProvider: string
{
    case Twitter = 'twitter';

    case GitHub = 'github';

    public function driver(): string
    {
        return match ($this) {
            self::Twitter => 'twitter-oauth-2',

            self::GitHub => 'github',
        };
    }
}

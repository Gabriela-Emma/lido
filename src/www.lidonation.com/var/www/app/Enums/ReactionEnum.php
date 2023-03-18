<?php

namespace App\Enums;

use Spatie\Enum\Enum;
use App\Models\Reactions\ReactionEyes;
use App\Models\Reactions\ReactionHeart;
use App\Models\Reactions\ReactionRocket;
use App\Models\Reactions\ReactionThumbsUp;
use App\Models\Reactions\ReactionThumbsDown;
use App\Models\Reactions\ReactionPartyPopper;

final class ReactionEnum extends Enum
{
    const REACTIONS = [
        '❤️' => ReactionHeart::class,
        '👍' => ReactionThumbsUp::class,
        '🎉' => ReactionPartyPopper::class,
        '🚀' => ReactionRocket::class,
        '👎' => ReactionThumbsDown::class,
        '👀' => ReactionEyes::class,
    ];

    public static function getClass(string $reaction): ?string
    {
        return self::REACTIONS[$reaction] ?? null;
    }
}
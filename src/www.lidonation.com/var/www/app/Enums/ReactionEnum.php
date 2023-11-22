<?php

namespace App\Enums;

use App\Models\Reactions\ReactionEye;
use App\Models\Reactions\ReactionHeart;
use App\Models\Reactions\ReactionPartyPopper;
use App\Models\Reactions\ReactionRocket;
use App\Models\Reactions\ReactionThumbsDown;
use App\Models\Reactions\ReactionThumbsUp;
use Spatie\Enum\Enum;

/**
 * @method static self heart()
 * @method static self thumbs_up()
 * @method static self party_popper()
 * @method static self rocket()
 * @method static self thumbs_down()
 * @method static self eye()
 */
final class ReactionEnum extends Enum
{
    const REACTIONS = [
        '❤️' => ReactionHeart::class,
        '👍' => ReactionThumbsUp::class,
        '🎉' => ReactionPartyPopper::class,
        '🚀' => ReactionRocket::class,
        '👎' => ReactionThumbsDown::class,
        '👀' => ReactionEye::class,
    ];

    public static function getClass(string $reaction): ?string
    {
        return self::REACTIONS[$reaction] ?? null;
    }

    protected static function values(): array
    {
        return [
            'heart' => '❤️',
            'thumbs_up' => '👍',
            'party_popper' => '🎉',
            'rocket' => '🚀',
            'thumbs_down' => '👎',
            'eye' => '👀',
        ];
    }
}

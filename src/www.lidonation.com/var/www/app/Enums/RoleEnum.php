<?php

namespace App\Enums;

// a Laravel specific base class
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self user()
 * @method static self translator()
 * @method static self proposer()
 * @method static self catalyst_profile()
 * @method static self delegator()
 * @method static self partner()
 * @method static self moderator()
 * @method static self editor()
 * @method static self sponsor()
 * @method static self event_manager()
 * @method static self admin()
 * @method static self super_admin()
 * @method static self learner()
 */
final class RoleEnum extends Enum
{
    protected static function values(): \Closure
    {
        return fn (string $name): string|int => str_replace('_', ' ', mb_strtolower($name));
    }
}

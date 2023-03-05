<?php

namespace App\Nova;

class OnboardingContent extends Articles
{
    public static $group = 'Posts';

    /**
     * Custom priority level of the resource.
     */
    public static int $priority = 5;

    /**
     * The model the resource corresponds to.
     */
    public static string $model = \App\Models\OnboardingContent::class;

    public static function label(): string
    {
        return 'Onboarding Content';
    }
}

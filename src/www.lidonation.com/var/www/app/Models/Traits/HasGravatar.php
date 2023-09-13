<?php

namespace App\Models\Traits;

use JetBrains\PhpStorm\Pure;

trait HasGravatar
{
    /**
     * The attribute name containing the email address.
     */
    public string $gravatarEmailField = 'email';

    #[Pure]
    public function getGravatarAttribute(): string
    {
        $hash = md5(strtolower(trim($this->{$this->getGravatarEmailField()})));

        return "https://www.gravatar.com/avatar/$hash?d=retro&r=r";
    }

    protected function getGravatarEmailField(): string
    {
        return $this->gravatarEmailField;
    }
}

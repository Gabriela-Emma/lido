<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasGravatar
{
    /**
     * The attribute name containing the email address.
     */
    public string $gravatarEmailField = 'email';

    public function gravatar(): Attribute
    {
        return Attribute::make(
            get: fn () => 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($this->{$this->getGravatarEmailField()}))).'?d=retro&r=r'
        );
    }

    protected function getGravatarEmailField(): string
    {
        return $this->gravatarEmailField;
    }
}

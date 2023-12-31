<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait UsesUuid
{
    /**
     * Override the boot function from Laravel so that
     * we give the model a new UUID when we create it.
     */
    protected static function boot(): void
    {
        parent::boot();

        $creationCallback = function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        };

        static::creating($creationCallback);
    }

    /**
     * Override the getIncrementing() function to return false to tell
     * Laravel that the identifier does not auto increment (it's a string).
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Tell laravel that the key type is a string, not an integer.
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}

<?php

namespace App\Models\Traits;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait HasTranslations
{
    use BaseHasTranslations {
        getTranslation as baseGetTranslation;
        getTranslations as baseGetTranslations;
    }

//    public function getTranslation(string $key, string $locale, bool $useFallbackLocale = true): mixed
//    {
//        $translation = $this->baseGetTranslation($key, $locale, $useFallbackLocale);
//        if ($this->hasGetMutator($key)) {
//            return $this->mutateAttribute($key, $translation);
//        }
//
//        if (!empty($translation)) {
//            return $translation;
//        }
//
//        if (!empty($this->getAttributes()) && isset($this->getAttributes()[$key])) {
//            return $this->getAttributes()[$key];
//        }
//
//        return null;
//    }

//    public function getTranslations(string $key = null, array $allowedLocales = null): array
//    {
//        if (app()->runningInConsole() && !is_array($this->getAttributes()[$key])) {
//            return [];
//        }
//        return $this->baseGetTranslations($key, $allowedLocales);
//    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, \App::getLocale());
        }

        return $attributes;
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class, 'source_id', 'id')
            ->where('source_type', static::class);
    }
}

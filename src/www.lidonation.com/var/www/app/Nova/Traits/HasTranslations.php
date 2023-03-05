<?php

namespace App\Nova\Traits;

use App\Models\Model;
use Illuminate\Support\Facades\Lang;
use Laravel\Nova\Fields\Markdown;

trait HasTranslations
{
    /**
     * Get the fields available on the action.
     */
    public function translationsFields(): array
    {
        $this->model()::withoutGlobalScopes();
        /** @var Model $model */
        $model = $this->model()::find(request()->resourceId);
        $group = $model?->getTable() ?? 'global';

        return collect(config('laravellocalization.supportedLocales'))
            ->filter(fn ($lang) => Lang::hasForLocale(
                "$group.".($model->slug ?? ($model?->name ?? $model?->title)),
                $lang['key']
            ))->map(fn ($lang) => Markdown::make(__($lang['native']), $lang['key'])
                ->withMeta([
                    'height' => '50px',
                ])
                ->resolveUsing(
                    fn () => Lang::get(
                        "$group.".($model->slug ?? ($model?->name ?? $model?->title)),
                        [],
                        $lang['key'],
                        false
                    )
                )
                ->showOnDetail()
                ->showOnUpdating()
            )->all();
    }
}

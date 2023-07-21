<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\Translation;
use App\Services\SettingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TranslationObserver
{
    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function creating(Translation $translation)
    {
        (new FillPostData)($translation, [], fn () => [
            'status' => ['status', 'published'],
            'group' => [
                'group',
                fn ($m, $k) => Str::plural(Str::lower(
                    collect(explode('\\', $m->source_type))
                        ->last()
                )),
            ],
            'key' => [
                'key',
                fn ($m, $k) => Str::lower(
                    "{$m->source_id}.{$m->source_field}"
                ),
            ],
            'user_id' => [
                'user_id',
                auth()?->user()?->getAuthIdentifier() ?? app(SettingService::class)->getSettings()?->system_user_id,
            ],
        ]);
    }

    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function updating(Translation $translation)
    {
        if ($translation->status === 'published' && ! isset($translation->published_at)) {
            $translation->published_at = now();
        }

        // if publish translation, update related model.
        if (isset($translation->published_at)) {
            $model = $translation->source_type::findOrFail($translation->source_id);
            $model->setTranslation(
                $translation->source_field,
                $translation->lang,
                $translation->content
            );
            $model->save();
        }

        // maybe assign owner
        $prevContent = $translation->getOriginal('content');
        if ((bool) $prevContent == false && $translation->user_id === app(SettingService::class)->getSettings()?->system_user_id) {
            if (Auth::check()) {
                $translation->user_id = Auth::user()->getAuthIdentifier();
            }
        }
    }

    // public function deleting(Translation $post)
    // {
    //     if ($post->forceDeleting) {
    //         $post->metas()->delete();
    //     }
    // }
}

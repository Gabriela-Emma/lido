<?php

namespace App\Observers;

use App\Models\Definition;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class DefinitionObserver
{
    public function saved(Definition $definition)
    {
        dispatch(fn () => Artisan::call('ln:sitemap-generate'));
    }

    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function creating(Definition $definition)
    {
        if (! $definition->slug) {
            $definition->slug = Str::slug($definition->name);
        }
        if (! $definition->status) {
            $definition->status = 'draft';
        }
    }

    protected function generateTranslations(Definition $definition)
    {
//        LanguageLine::updateOrCreate(
//            [
//                'group' => 'definitions',
//                'key' =>  "{$definition->slug}.title",
//            ],
//            [
//                'group' => 'definitions',
//                'key' => "{$definition->slug}.title",
//                'text' => [
//                    'en' => $definition->title,
//                ],
//            ]
//        );
//        LanguageLine::updateOrCreate(
//            [
//                'group' => 'definitions',
//                'key' =>  "{$definition->slug}.content",
//            ],
//            [
//                'group' => 'definitions',
//                'key' => "{$definition->slug}.content",
//                'text' => [
//                    'en' => $definition->content,
//                ],
//            ]
//        );
    }
}

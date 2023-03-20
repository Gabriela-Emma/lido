<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Jobs\SyncTranslationJob;
use App\Models\Meta;
use App\Models\Translation;
use App\Models\User;
use App\Services\TranslationService;

class ProposalTranslationController extends Controller
{
    public function validateUser(Request $request)
    {
        $user = $request->user();

        if(!isset($user)){
            return;
        }
        
        // user translation meta
        $translators_lang = $this->getTranslatorMetas($user);

        // if existing translator
        if(isset($translators_lang)){
            return $translators_lang;
        }

        // if new translator
        $user->assignRole((string) RoleEnum::translator());

        return $user;
    }

    public function getLanguageOptions(Proposal $proposal)
    {   $exclude = ['en', 'sw'];

        $excludedLangs = array_merge($exclude, $this->transalatedLangs($proposal));

        $locales = config('laravellocalization.supportedLocales');

        $result = array_map(function ($locale) use ($excludedLangs) {
            if (in_array($locale['key'], $excludedLangs)) {
                return null;
            }
        
            return [
                'name' => $locale['native'],
                'value' => $locale['key'],
            ];
        }, $locales);
        
        // Remove null values from the resulting array
        $result = array_filter($result);
        
        $json = json_encode(array_values($result));
        return $json;
    }

    public function makeTranslation(Request $request, Proposal $proposal)
    {   
        if(null === $this->getTranslatorMetas($request->user)){
            $this->setTranslatorMetas($request->user, $request->targetLanguage);
        }

        // get new translation 
        SyncTranslationJob::dispatch($proposal, 'content', $request->sourceLanguage, $request->targetLanguage, true, true);

        $translation = null;

        while ($translation === null ) {
            $translation = Translation::where('source_id', $proposal->id)->where('lang', $request->targetLanguage)->first();
            sleep(1);
        }
        
        return $translation->content;
    }

    public function updateTranslation(Request $request, Proposal $proposal)
    {
        $translation = Translation::where('source_id', $proposal->id)->where('lang', $request->translationLang)->first();

        $translation->content = $request->updates;

        $translation->save();

        return $translation->content;
    }

    public function transalatedLangs(Proposal $proposal)
    {
        $existingLangs = Translation::where('source_id', $proposal->id)->pluck('lang');

        return $existingLangs->toArray();
    }

    public function setTranslatorMetas(User $user, $lang)
    {
        $meta = new Meta;
        $meta->model_type = $user::class;
        $meta->model_id = $user->id;
        $meta->key = 'lang';
        $meta->content = $lang;
        $meta->save();
        
    }

    public function getTranslatorMetas(User $user)
    {
        $USER_TRANSLATES_LANGUAGE = $user->metas()->where('key', 'lang')->pluck('content');

        return $USER_TRANSLATES_LANGUAGE;
    }


}

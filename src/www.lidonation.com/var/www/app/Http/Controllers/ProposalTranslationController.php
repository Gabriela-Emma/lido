<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Jobs\SyncTranslationJob;
use App\Models\Translation;
use App\Services\TranslationService;

class ProposalTranslationController extends Controller
{
    public function getLanguageOptions() 
    {
        $locales = config('laravellocalization.supportedLocales');

        $result = array_map(function ($locale) {
            return [
                'name' => $locale['native'],
                'value' => $locale['key'],
            ];
        }, $locales);
        
        $json = json_encode(array_values($result));
        return $json;
    }

    public function makeTranslation(Request $request, Proposal $proposal)
    {   
        $existingTranslation = Translation::where('source_id', $proposal->id)->where('lang', $request->targetLanguage)->first();

        // return existing translation
        if(isset($existingTranslation))
        {
            $existingTranslation->content;
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

    function updateTranslation(Request $request, Proposal $proposal)
    {
        $translation = Translation::where('source_id', $proposal->id)->where('lang', $request->translationLang)->first();

        $translation->content = $request->updates;

        $translation->save();

        return $translation->content;
    }
}

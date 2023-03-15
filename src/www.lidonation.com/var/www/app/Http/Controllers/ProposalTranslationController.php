<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Service\Translate;
use App\Services\TranslationService;

class ProposalTranslationController extends Controller
{
    public function getLanguageOptions() 
    {
        $locales = config('laravellocalization.supportedLocales');

        $result = array_map(function ($locale) {
            return [
                'name' => $locale['native'],
                'value' => strtolower(substr($locale['key'], 0, 2)),
            ];
        }, $locales);
        
        $json = json_encode(array_values($result));
        return $json;
    }

    public function makeTranslation(Request $request, TranslationService $translationService)
    {

        
    }
}

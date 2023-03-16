<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
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
                'value' => $locale['key'],
            ];
        }, $locales);
        
        $json = json_encode(array_values($result));
        return $json;
    }

    public function makeTranslation(Request $request, Proposal $proposal)
    {
        dd($request->segment(1));
        
    }
}

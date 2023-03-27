<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Meta;
use App\Models\Translation;
use App\Models\User;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProposalTranslationController extends Controller
{
    public $field = 'content';

    public function validateUser(Request $request)
    {
        $user = $request->user();
        if (! isset($user)) {
            return response()->json([]);
        }
        // user translation meta
        $translators_lang = $this->getTranslatorMetas($user);
        // if existing translator
        if (isset($translators_lang) && $user->hasRole(['translator'])) {
            return $translators_lang;
        }
        // if new translator
        $user->assignRole((string) RoleEnum::translator());

        return $user->id;
    }

    public function getLanguageOptions(Request $request)
    {
        $model = $this->matchModel($request->model_type, $request->model_id);

        $existingTranslatedLangs = $model->getTranslatedLocales('content');

        $defaultExclutions = ['en', 'sw'];

        $excludedLangs = array_merge($existingTranslatedLangs, $defaultExclutions);

        $allLocales = config('laravellocalization.supportedLocales');

        $result = array_map(function ($allLocales) use ($excludedLangs) {
            if (in_array($allLocales['key'], $excludedLangs)) {
                return null;
            }

            return [
                'name' => $allLocales['native'],
                'value' => $allLocales['key'],
            ];
        }, $allLocales);

        // Remove null values from the resulting array
        $result = array_filter($result);
        $json = json_encode(array_values($result));

        return $json;
    }

    public function makeTranslation(Request $request, TranslationService $translationService)
    {
        $model = $this->matchModel($request->model_type, $request->model_id);

        if ($this->getTranslatorMetas($request->user()) === null) {
            $this->setTranslatorMetas($request->user(), $request->targetLanguage);
        }

        $content = $model->getTranslation($this->field, $request->sourceLanguage, false);

        $translationService = $translationService
            ->setTargetLang($request->targetLanguage)
            ->setSourceLang($request->sourceLanguage);

        $translationService = $translationService->translate($content, $request->targetLanguage, $request->sourceLanguage);
        $translationService->save($model, $this->field);

        return $translationService->get();
    }

    public function updateTranslation(Request $request)
    {
        $model = $this->matchModel($request->model_type, $request->model_id);

        $translation = Translation::where('source_id', $request->model_id)->where('lang', $request->targetLanguage)->first();
        $translation->update([
            'content' => $request->content,
            'published_at' => now(),
            'status' => 'published',
        ]);

        $model->setTranslation($this->field, $request->targetLanguage, $translation->content);

        $translatedContent = null;
        while ($translatedContent === null) {
            $translatedContent = $model->getTranslation($this->field, $request->targetLanguage, false);
            sleep(1);
        }

        return $translatedContent;
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
        $USER_TRANSLATES_LANGUAGE = $user->metas()->where('key', 'lang')->pluck($this->field)->first();

        return $USER_TRANSLATES_LANGUAGE;
    }

    public function matchModel($modelTable, $model_id)
    {
        $modelType = 'App\\Models\\'.Str::studly(Str::singular($modelTable));

        return $modelType::find($model_id);
    }
}

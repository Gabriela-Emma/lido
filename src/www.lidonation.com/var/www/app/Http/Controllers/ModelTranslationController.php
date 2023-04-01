<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Meta;
use App\Models\Translation;
use App\Models\User;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModelTranslationController extends Controller
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
        $excludedLangs = array_merge($existingTranslatedLangs, ['en', 'sw']);
        $availableLocales = collect(config('laravellocalization.supportedLocales'))->forget($excludedLangs)->toArray();
        $result = array_map(function ($availableLocales) {
            return [
                'name' => $availableLocales['native'],
                'value' => $availableLocales['key'],
            ];
        }, $availableLocales);
        return  json_encode(array_values($result));
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
        $translationService->save($model, $this->field, false);
        return $translationService->get();
    }

    public function updateTranslation(Request $request)
    {
        $model = $this->matchModel($request->model_type, $request->model_id);
        $translation = Translation::where('source_id', $request->model_id)->where('lang', $request->targetLanguage)->first();
        $translation->content = $request->content;
        $translation->published_at = now();
        $translation->save();

        $model->refresh();
        return $model->getTranslation('content', $request->targetLanguage, false);
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

    public function getContent(Request $request)
    {
        $model = $this->matchModel($request->model_type, $request->model_id);
        $modelContent = $model->getTranslation($this->field, $request->sourceLocale, false);
        if($modelContent == null){
            return $model->getTranslation($this->field, 'en', false);
        }
        return $modelContent;
    }
}

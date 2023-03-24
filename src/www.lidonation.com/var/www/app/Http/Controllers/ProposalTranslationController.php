<?php
namespace App\Http\Controllers;
use App\Models\Meta;
use App\Models\Post;
use App\Models\User;
use App\Models\Model;
use App\Enums\RoleEnum;
use App\Models\Proposal;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Jobs\SyncTranslationJob;
use App\Models\Insight;
use App\Models\News;
use App\Models\Review;
class ProposalTranslationController extends Controller
{
    public function validateUser(Request $request)
    {
        $user = $request->user();
        if(!isset($user)){
            return response()->json([]);
        }
        // user translation meta
        $translators_lang = $this->getTranslatorMetas($user);
        // if existing translator
        if(isset($translators_lang) && $user->hasRole(['translator'])){
            return $translators_lang;
        }
        // if new translator
        $user->assignRole((string) RoleEnum::translator());
        return $user->id;
    }
    public function getLanguageOptions(Request $request)
    {
        $model = $this->matchModel($request->model_type, $request->model_id);
        $exclude = ['en', 'sw'];
        $excludedLangs = array_merge($exclude, $this->transalatedLangs($model));
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
    public function makeTranslation(Request $request)
    {
        $model = $this->matchModel($request->model_type, $request->model_id);
        if( $this->getTranslatorMetas($request->user()) === null){
            $this->setTranslatorMetas($request->user(), $request->targetLanguage);
        }
        // get new translation
        SyncTranslationJob::dispatch($model, 'content', $request->sourceLanguage, $request->targetLanguage, true, true);
        $translation = null;
        while ($translation === null ) {
            $translation = Translation::where('source_id', $request->model_id)->where('lang', $request->targetLanguage)->first();
            sleep(1);
        }
        return $translation->content;
    }
    public function updateTranslation(Request $request)
    {
        $translation = Translation::where('source_id', $request->model_id)->where('lang', $request->targetLanguage)->get();
        $translation->content = $request->content;
        return $translation->content;
    }
    public function transalatedLangs(Model $model)
    {
        $existingLangs = Translation::where('source_id', $model->id)->pluck('lang');
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
        $USER_TRANSLATES_LANGUAGE = $user->metas()->where('key', 'lang')->pluck('content')->first();
        return $USER_TRANSLATES_LANGUAGE;
    }
    Public function matchModel($modelTable , $model_id)
    {
        $modelType = match ($modelTable) {
            'proposal' => Proposal::class,
            'AppModelsPost' => Post::class,
            'AppModelsOnboardingContent' => OnboardingContent::class,
            'AppModelsNews' => News::class,
            'AppModelsExternalPost' => ExternalPost::class,
            'AppModelsInsights' => Insight::class,
            'AppModelsReviews' => Review::class
        };
        return $modelType::find($model_id);
    }
}
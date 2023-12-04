<?php

namespace App\Livewire\Contribute\Translations;

use App\Models\Post;
use App\Models\Model;
use App\Scopes\LimitScope;
use App\Models\Translation;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use App\Models\Commitment;

#[Layout('layouts.contribute')]
class ContributeTranslations extends Component
{
    public ?string $translatingTo;

    public ?Collection $translations;

    public $perPage = 50;

    public $onlyMine = false;

    public $completed = false;

    public $inProgress = false;

    public $filter = 'all';

    public ?Model $model;

    public ?Collection $fields;

    protected ?Translation $translation;

    public $user;

    public $locales;

    public function toggleFilter($filter)
    {
        // Set the current filter based on the provided parameter
        $this->filter = $filter;

        // Reset other filter flags
        $this->onlyMine = false;
        $this->completed = false;
        $this->inProgress = false;

        if ($filter === 'all') {
        } elseif ($filter === 'onlyMine') {
            $this->onlyMine = true;
        } elseif ($filter === 'completed') {
            $this->completed = true;
        } elseif ($filter === 'inProgress') {
            $this->inProgress = true;
        }

        // Refresh the Livewire component to trigger a re-render with the updated filter
        $this->render();
    }

    public function commitToTranslation($translationId)
{
    $this->user = Auth::user();

    $existingCommitment = Commitment::where('model_id', $translationId)
        ->where('model_class', Translation::class)
        ->first();

    if (!$existingCommitment) {
        Commitment::create([
            'user_id' => $this->user->id,
            'lang' => $this->user->lang,
            'model_id' => $translationId,
            'model_class' => Translation::class,
        ]);
        $translation = Translation::find($translationId);
        $translation->status = 'committed';
        $translation->save();

        $this->render();
    }
}
    public function render()
    {

        $this->user = Auth::user();

        $this->locales = config('laravellocalization.supportedLocales');

        Post::withoutGlobalScope(LimitScope::class);
        $translatables = Post::with('commitments')->whereDoesntHave('commitments', function (Builder $query) {
            $query->where('lang', $this->user->meta_data->lang);
        })->get();

        $this->translations = $translatables
            ->sortBy('source_id')
            ->sortBy('source_type');

            return view('livewire.contribute.translations.index', [
                'translations' => $this->translations,
            ]);
    }
}

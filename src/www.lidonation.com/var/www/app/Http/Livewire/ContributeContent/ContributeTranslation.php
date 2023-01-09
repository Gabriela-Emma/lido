<?php

namespace App\Http\Livewire\ContributeContent;

use App\Models\Model;
use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;
use LivewireUI\Modal\ModalComponent;

class ContributeTranslation extends ModalComponent
{
    public ?Model $model;

    public ?Collection $fields;

    public ?\Illuminate\Database\Eloquent\Collection $translations;

    public ?string $translatingTo;

    public ?bool $submittingTranslation = false;

    public ?bool $translationSubmitted = false;

    protected ?Translation $translation;

    protected $listeners = [
        'preTranslate' => 'preTranslate',
        'submitTranslation' => 'submitTranslation',
        'back' => 'back',
    ];

    // form
    public ?string $content = null;

    protected array $rules = [];

    public function back()
    {
        unset($this->translation);
        $this->submittingTranslation = false;
    }

    public function translateContent(Translation $translation)
    {
        $this->translation = $translation;
        $this->submittingTranslation = true;
        $this->updateEditor();
    }

    #[NoReturn]
    public function preTranslate(Translation $translation, TranslationService $translationService)
    {
        $translation->content = $translationService
            ->translate($translation->source_content, $translation->lang)
            ->save($translation, $translation->source_field)
            ->get();
        $this->translation = $translation;
        $this->updateEditor();
    }

    #[NoReturn]
    public function submitTranslation(Translation $translation, string $markdown, bool $publish = false)
    {
        $translation->content = $markdown;
        if ($publish) {
            $translation->status = 'published';
        }

        $translation->save();
        $this->translation = $translation;
        $this->translationSubmitted = true;

        $this->updateEditor();
    }

    public function reset(...$properties)
    {
        parent::reset($properties);
        $this->submittingTranslation = false;
        $this->translationSubmitted = false;
    }

    public function mount(Translation $translation)
    {
        $this->translation = $translation;
        $this->model = $translation->source;
        $this->fields = collect($this->model->translatable)
            ->filter(
                fn ($field) => ! in_array($field, $this->model->translatableExcludedFromGeneration)
            );
        $this->translations = Translation::orWhere([
            ['source_id', $this->model->id],
            ['source_type', get_class($this->model)],
            ['lang', $this->translation->lang],
        ])->get();
        if (Auth::check()) {
            $locales = config('laravellocalization.supportedLocales');
            $translates = Auth::user()->meta_data?->translates;
            if ((bool) $translates) {
                $this->translatingTo = $locales[$translates]['native'];
            }
        }
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.contribute-content.contribute-translation')->layout('layouts.app', [
            'metaTitle' => 'Contribute Translation',
        ]);
    }

    protected function updateEditor()
    {
        $this->emit('translate-content', [
            'id' => $this->translation->id,
            'updated' => $this->translation->updated_at?->diffForHumans(),
            'content' => $this->translation->content ?? '',
        ]);
    }
}

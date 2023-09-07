<?php

namespace App\Http\Livewire\Translations;

use App\Models\Insight;
use App\Models\News;
use App\Models\OnboardingContent;
use App\Models\Proposal;
use App\Models\Review;
use App\Models\Snippet;
use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class TranslationsComponent extends LivewireDatatable
{
    public $model = Translation::class;

    public $perPage = 50;

    public $exportable = false;

    public $beforeTableSlot = 'livewire.translations.before';

    public bool $onlyMissing = false;

    public bool $onlyMine = false;

    public bool $groupRelated = false;

    public ?string $filter = null;

    protected $listeners = [
        'toggleMissing' => 'toggleMissing',
        'toggleGroupRelated' => 'toggleGroupRelated',
        'toggleOnlyMine' => 'toggleOnlyMine',
        'toggleFilter' => 'toggleFilter',
    ];

    protected $query;

    public function builder()
    {
        if (! $this->query) {
            $user = Auth::user();
            $this->query = Translation::where('lang', $user->meta_data->translates);
        }

        if ($this->onlyMissing) {
            $this->query->missingTranslation();
        }

        if ($this->onlyMine) {
            $this->query->myTranslations();
        }

        if ($this->groupRelated) {
            if (in_array($this->filter, ['news', 'insights', 'reviews', 'onbaording'])) {
                $this->query->sourceField('title');
            }
        }

        if ($this->filter) {
            switch ($this->filter) {
                case 'news':
                    $this->query->sourceType(News::class);
                    break;
                case 'reviews':
                    $this->query->sourceType(Review::class);
                    break;
                case 'insights':
                    $this->query->sourceType(Insight::class);
                    break;
                case 'onboarding':
                    $this->query->sourceType(OnboardingContent::class);
                    break;
                case 'proposal':
                    $this->query->sourceType(Proposal::class);
                    break;
                case 'snippets':
                    $this->query->sourceType(Snippet::class);
                    break;
            }
        }

        $this->query
            ->orderBy('source_id')
            ->orderBy('source_type');

        return $this->query;
    }

    public function toggleGroupRelated($groupRelated)
    {
        $this->groupRelated = $groupRelated;
    }

    public function toggleOnlyMine($onlyMine)
    {
        $this->onlyMine = $onlyMine;
    }

    public function toggleMissing($missing)
    {
        $this->onlyMissing = $missing;
    }

    public function toggleFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * the order of the columns matter.
     */
    public function columns(): array
    {
        return [

            Column::name('source_id')
                ->excludeFromExport()->unsortable()
                ->label('Related Object'),

            Column::callback('source_type', 'computeType')
                ->unsortable()->excludeFromExport()
                ->label('Type'),

            Column::name('source_content')
                ->unsortable()
                ->label('Source Text'),

            Column::name('content')
                ->unsortable()
                ->label('Translation')->editable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.translations.table-actions', ['id' => $id]);
            })->unsortable()->excludeFromExport(),
        ];
    }

    public function getMissingProperty(): bool
    {
        return true;
    }

    public function edited($value, $key, $column, $rowId)
    {
        $translation = Translation::findOrFail($rowId);
        $translation->{$column} = $value;
        $translation->status = 'published';
        $translation->save();

        $this->emit('fieldEdited', $translation->id);
    }

    public function computeType($source_type)
    {
        return collect(explode('\\', $source_type))->last();
    }
}

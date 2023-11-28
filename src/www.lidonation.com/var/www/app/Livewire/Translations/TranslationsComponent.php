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
use Livewire\Component;

class TranslationsComponent extends Component
{
    public $translations;

    public $perPage = 50;

    public $onlyMissing = false;

    public $onlyMine = false;

    public $groupRelated = false;

    public $filter = null;

    public function render()
    {
        $user = Auth::user();

        $query = Translation::where('lang', $user->meta_data->translates);

        if ($this->onlyMissing) {
            $query->missingTranslation();
        }

        if ($this->onlyMine) {
            $query->myTranslations();
        }

        if ($this->groupRelated) {
            if (in_array($this->filter, ['news', 'insights', 'reviews', 'onboarding'])) {
                $query->sourceField('title');
            }
        }

        if ($this->filter) {
            switch ($this->filter) {
                case 'news':
                    $query->sourceType(News::class);
                    break;
                case 'reviews':
                    $query->sourceType(Review::class);
                    break;
                case 'insights':
                    $query->sourceType(Insight::class);
                    break;
                case 'onboarding':
                    $query->sourceType(OnboardingContent::class);
                    break;
                case 'proposal':
                    $query->sourceType(Proposal::class);
                    break;
                case 'snippets':
                    $query->sourceType(Snippet::class);
                    break;
            }
        }

        $this->translations = $query
            ->orderBy('source_id')
            ->orderBy('source_type')
            ->paginate($this->perPage);

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

        $this->dispatch('fieldEdited', $translation->id);
    }

    public function computeType($source_type)
    {
        return collect(explode('\\', $source_type))->last();
    }
}

<?php

namespace App\Livewire\Components;

use App\Invokables\LidoOriginStats;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LidoOriginStoryAndStats extends Component
{
    public string $theme;

    public int $newsArticles;

    public int $educationalArticles;

    public int $minutesOfAudioReadings;

    public int $hrsOfTwitterSpacesWork;

    public ?int $thirtyDaysPageViews;

    public int $thirtyDaysCatalystQueries;

    public function mount(string $theme): void
    {
        $this->theme = $theme ?? 'teal';
        [
            $this->newsArticles, $this->educationalArticles,
            $this->minutesOfAudioReadings, $this->hrsOfTwitterSpacesWork,
            $this->thirtyDaysPageViews, $this->thirtyDaysCatalystQueries
        ] = (new LidoOriginStats)();
    }

    public function render(): Factory|View|Application
    {

        return view('livewire.components.lido-origin-stats');
    }

    public function placeholder()
    {
        return view('components.placeholder.origin-placeholder');
    }
}

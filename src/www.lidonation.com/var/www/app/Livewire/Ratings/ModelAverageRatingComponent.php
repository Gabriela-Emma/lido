<?php

namespace App\Livewire\Ratings;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ModelAverageRatingComponent extends Component
{
    public int $modelId;

    public string $modelType;

    public ?float $averageRating;

    public ?float $averageRatingFormatted;

    public ?int $ratingsCount;

    public ?string $theme = 'yellow';

    public ?int $size = 5;

    public function mount()
    {
        if ($this->modelType && $this->modelId) {
            $proposal = $this->modelType::find($this->modelId);
            $this->averageRatingFormatted = $proposal->ratings_average_formatted;
            $this->averageRating = $proposal->ratings_average;
            $this->ratingsCount = $proposal->ratings_count;
        }
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.ratings.model-average-rating');
    }
}

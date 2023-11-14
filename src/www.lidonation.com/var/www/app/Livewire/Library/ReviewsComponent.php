<?php

namespace App\Livewire\Library;

use App\Models\Review;
use App\Repositories\PostRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Component;

class ReviewsComponent extends Component
{
    public ?Collection $reviews;

    public int $limit = 3;

    public function mount(PostRepository $posts): void
    {
        $this->reviews = $posts->setModel(new Review)->limit($this->limit)->all();
    }

    public function placeholder(): View|Application|Factory
    {
        $groups = collect(range(1, $this->limit))->chunk(3);

        return view('components.placeholder.library-reviews-placeholder')->with([
            'groups' => $groups,
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.library.reviews');
    }
}

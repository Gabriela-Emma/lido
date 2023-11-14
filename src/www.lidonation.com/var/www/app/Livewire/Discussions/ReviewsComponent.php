<?php

namespace App\Livewire\Discussions;

use App\Models\Discussion;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ReviewsComponent extends Component
{
    public Discussion $discussion;

    public $reviews;

    public string $background = '';

    public bool $editable = true;

    public function render(): Factory|View|Application
    {
        return view('livewire.discussions.reviews');
    }
}

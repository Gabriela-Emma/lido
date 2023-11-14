<?php

namespace App\Livewire\Discussions;

use App\Models\Discussion;
use App\Models\Model;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DiscussionComponent extends Component
{
    public Discussion $discussion;

    public Model $model;

    public string $background = '';

    public bool $editable = true;

    public bool $expanded = false;

    public function render(): Factory|View|Application
    {
        return view('livewire.discussions.discussion-accordion');
    }
}

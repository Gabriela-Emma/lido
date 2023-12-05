<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Spatie\LivewireComments\Livewire\CommentsComponent;

class CommentComponent extends CommentsComponent
{
    public function render(): View
    {
        return view('livewire.comment-component');
    }
}

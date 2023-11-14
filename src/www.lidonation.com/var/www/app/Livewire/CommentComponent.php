<?php

namespace App\Livewire;

use Spatie\LivewireComments\Livewire\CommentsComponent;

class CommentComponent extends CommentsComponent
{
    public function render()
    {
        return view('livewire.comment-component');
    }
}

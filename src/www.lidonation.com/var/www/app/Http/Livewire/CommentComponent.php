<?php

namespace App\Http\Livewire;

use Spatie\LivewireComments\Livewire\CommentsComponent;

class CommentComponent extends CommentsComponent
{
    public function render()
    {
        return view('livewire.comment-component');
    }
}

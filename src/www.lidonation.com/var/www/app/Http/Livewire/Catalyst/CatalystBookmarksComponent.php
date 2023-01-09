<?php

namespace App\Http\Livewire\Catalyst;

use App\Repositories\CatalystUserRepository;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

/**
 * to index run php artisan ln:index ln__proposals 'funded,over_budget,challenge,fund'
 */
class CatalystBookmarksComponent extends ModalComponent
{
    public function render(PostRepository $posts, CatalystUserRepository $catalystUserRepository): Factory|View|Application
    {
        return view('livewire.catalyst.proposal.bookmarks');
    }
}

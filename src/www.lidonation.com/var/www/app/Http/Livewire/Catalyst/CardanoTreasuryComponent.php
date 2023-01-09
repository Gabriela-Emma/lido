<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\Fund;
use App\Models\Snippet;
use App\View\Components\PublicLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class CardanoTreasuryComponent extends Component
{
    public array $funds;

    public array $pageSnippets;

    public function mount()
    {
        $this->funds = Fund::orderBy('launched_at', 'desc')
            ->orderBy('title', 'asc')
            ->whereHas('parent', fn ($q) => $q->where('title', 'Fund 7'))
            ->whereDoesntHave(
                'categories',
                fn (Builder $query) => $query->where('slug', '=', 'challenge-setting')
            )
            ->get()
            ->filter(fn ($f) => ($f->wining_proposals->isNotEmpty()))
            ->all();

        $this->pageSnippets = Snippet::where('context', 'treasury-dashboard')
            ->orderBy('order')
            ->get()
            ->all();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.catalyst.proposal.funds', (new PublicLayout())->data())
            ->layoutData([
                'metaTitle' => 'Cardano Treasury',
            ]);
    }
}

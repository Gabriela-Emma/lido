<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\CatalystGroup;
use App\Models\CatalystUser;
use App\Models\Fund;
use App\Models\Model;
use App\Models\Post;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Livewire\Component;

class CatalystSubMenuComponent extends Component
{
    public string $path;

    public Collection $crumbs;

    protected Collection $routeParts;

    protected Model|User|null $model;

    protected string $section;

    public function mount()
    {
        $this->init()
            ->setSection()
            ->setModel()
            ->buildBreadCrumbs();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.catalyst.submenu');
    }

    protected function init(): static
    {
        if (request()->routeIs('proposal')) {
            $this->routeParts = collect(explode('/', Str::after(url()->current(), 'proposals')))
                ->filter()
                ->prepend('proposals');
        } else {
            $this->routeParts =
            collect(explode('/', Str::after(url()->current(), 'catalyst-explorer')))->filter();

        }

        $this->path = $this->routeParts->last();
        $this->crumbs = collect([
            [
                'label' => 'Dashboard',
                'link' => route('projectCatalyst.dashboard'),
                'order' => 0,
            ],
        ]);

        return $this;
    }

    protected function setSection(): static
    {
        $this->section = $this->routeParts->first();
        $this->section = match ($this->section) {
            'challenges' => 'funds',
            'group' => 'groups',
            default => $this->section
        };

        return $this;
    }

    protected function setModel(): static
    {
        switch ($this->section) {
            case 'proposals':
                $this->setProposal();
                break;
            case 'funds':
                $this->setFund();
                break;
            case 'groups':
                $this->setGroup();
                break;
            case 'users':
                $this->setUser();
                break;
            default:
                $this->setPost();
        }

        return $this;
    }

    protected function setUser(): static
    {
        if (! intval($this->path) > 0) {
            $this->model = null;

            return $this;
        }
        $this->model = CatalystUser::find($this->path);

        return $this;
    }

    protected function setProposal(): static
    {
        $this->model = Proposal::where('slug', $this->path)
            ->first();

        return $this;
    }

    protected function setGroup(): static
    {
        $this->model = CatalystGroup::where('slug', $this->path)->first();

        return $this;
    }

    protected function setFund(): static
    {
        $this->model = Fund::where('slug', $this->path)->first();

        return $this;
    }

    protected function setPost(): static
    {
        if (! intval($this->path) > 0) {
            $this->model = null;

            return $this;
        }
        $this->model = ($this->getModelClass())::find($this->path);

        return $this;
    }

    protected function buildBreadCrumbs(): static
    {
        $routeName = Str::camel($this->section);
        if ($this->section && $this->section !== 'dashboard' && Route::has("catalystExplorer.{$routeName}")) {
            $this->crumbs->push([
                'label' => Str::title(Str::replace('-', ' ', $this->section)),
                'link' => route("catalystExplorer.{$routeName}"),
                'order' => $this->crumbs->count() + 1,
            ]);
        }

        if ($this->section === 'proposals' && $this->model) {
            $this->crumbs->push([
                'label' => 'Funds',
                'link' => route('catalystExplorer.funds'),
                'order' => $this->crumbs->count() + 3,
            ]);
            $this->crumbs->push([
                'label' => $this->model->fund?->parent?->label,
                'link' => $this->model->fund?->parent?->link,
                'order' => $this->crumbs->count() + 5,
            ]);
            $this->crumbs->push([
                'label' => $this->model->fund?->label,
                'link' => $this->model->fund?->link,
                'order' => $this->crumbs->count() + 7,
            ]);
        }

        if ($this->section === 'funds' && $this->model?->parent) {
            $this->crumbs->push([
                'label' => $this->model->parent->label,
                'link' => $this->model->parent->link,
                'order' => $this->crumbs->count() + 5,
            ]);
        }

        if ($this->model instanceof Model || $this->model instanceof User) {
            $this->crumbs->push([
                'label' => $this->model->label ?? $this->model->name ?? $this->model->title,
                'link' => $this->model->link,
                'order' => $this->crumbs->count() + 9,
            ]);
        }

        $this->crumbs = $this->crumbs->mapInto(Fluent::class);

        return $this;
    }

    protected function getModelClass(): string
    {
        return match ($this->section) {
            'projects' => Proposal::class,
            'groups' => CatalystGroup::class,
            'users' => CatalystUser::class,
            'funds' => Fund::class,
            default => Post::class,
        };
    }
}

<?php

namespace App\Http\View\Composers;

use App\Models\CatalystUser;
use App\Models\Insight;
use App\Models\News;
use App\Models\Podcast;
use App\Models\Post;
use App\Models\Proposal;
use App\Models\Review;
use App\Models\User;
use App\Repositories\EventRepository;
use App\Repositories\PostRepository;
use App\Scopes\LimitScope;
use Illuminate\Support\Fluent;
use Illuminate\View\View;

class HomeComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct(protected PostRepository $posts, protected EventRepository $events)
    {
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $insights = $this->posts->setModel(new Insight)->limit(6)->all();
        $reviews = $this->posts->setModel(new Review)->limit(2)->all();
        $events = $this->events->upcoming();
        $users = User::whereHas('roles', fn ($query) => $query->whereIn('name', ['super admin']))->get();

        //@todo move this to an invokable class
        $latestLidoMinute = Podcast::where('status', 'published')->orderBy('published_at', 'DESC')->first();

        Post::withoutGlobalScopes([LimitScope::class]);
        $newToLibrary = Post::whereIn('type', [
            News::class,
            Review::class,
            Insight::class,
        ])->limit($latestLidoMinute instanceof Podcast ? 3 : 4)->get()->map(fn ($m) => $m->load(['media', 'tags']));

        $view->with(
            [
                'users' => $users,
                'reviews' => $reviews,
                'insights' => $insights,
                'newToLibrary' => $newToLibrary->sortByDesc('published_at'),
                'latestLidoMinute' => $latestLidoMinute,
                'quickPitches' => Proposal::whereRelation('metas', 'key', '=', 'quick_pitch')
                    ->whereRelation('fund', 'parent_id', '=', 113)
                    ->where('quickpitch_length', '<', 215)
                    ->inRandomOrder()
                    ->limit(8)
                    ->get(),
                'proposal' => Proposal::inRandomOrder()
                    ->where('status', 'complete')
                    ->whereNotNull('solution')
                    ->first(),
                'catalystArticle' => ($this->posts->setModel(new Insight)->limit(1)->getQuery())
                    ->whereHas('tags', fn ($q) => ($q->where('slug', 'project-catalyst')))
                    ->inRandomOrder()->get()->first(),
                'events' => $events,
                'stats' => new Fluent([
                    'completedProposals' => Proposal::where('type', 'proposal')
                        ->where('status', 'complete')
                        ->sum('amount_received'),
                    'proposalsCount' => Proposal::where('type', 'proposal')
                        ->whereNotNull('funded_at')
                        ->count(),
                    'numberOfBuilders' => CatalystUser::whereHas('proposals')
                        ->count(),
                    'avgFundedProposals' => Proposal::whereNotNull('funded_at')
                        ->where('type', 'proposal')
                        ->avg('amount_requested'),
                ]),
                'pages' => new Fluent([
                    'pool' => $this->posts->setModel(new Post)->get('about-the-pool'),
                ]),
            ]
        );
    }
}

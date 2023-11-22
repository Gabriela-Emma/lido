<?php

declare(strict_types=1);

namespace App\Livewire\GlobalSearch;

use App\DataTransferObjects\PostSearchResultData;
use App\Models\Meta;
use App\Models\Post;
use App\Models\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Meilisearch\Endpoints\Indexes;

class GlobalSearchComponent extends Component
{
    public int $postId;

    public int $votes;

    public bool $voted = false;

    public Post $post;

    public string $inputTerm = '';

    public $searchResults;

    public array $displayData;

    public array $allItems;

    public array $reviewsItems;

    public array $postsItems;

    public string $selectedType = 'all';

    public bool $show = false;

    public function updated($property): void
    {
        if ($property === 'inputTerm' && ! empty($this->inputTerm)) {
            $this->searchResults = $this->getSearchData();
            $this->extractAndOrganizeData();
            $this->setAll();
        }

        if ($this->inputTerm === '') {
            $this->displayData = [];
            $this->allItems = [];
            $this->reviewsItems = [];
        }
    }

    public function setAll(): void
    {
        $this->displayData = $this->allItems;
        $this->selectedType = 'all';
    }

    public function setReviews(): void
    {
        $this->displayData = $this->reviewsItems;
        $this->selectedType = 'reviews';
    }

    public function getSearchData()
    {
        if (isset($this->inputTerm)) {
            $term = $this->inputTerm;
        }
        $searchBuilder = Post::search(
            $term,
            function (Indexes $index, $query, $options) {
                $options['filter'] = ' status = published';
                $options['limit'] = 30;

                return $index->search($query, $options);
            }
        );
        $results = $searchBuilder->raw();
        if (! isset($results['hits'])) {
            return [];
        }
        $hits = collect($results['hits']);

        return $hits->map(function ($hit) {
            $hit['type'] = match ($hit['type']) {
                Review::class => 'reviews',
                default => 'posts',
            };

            return $hit;
        })->groupBy('type')
            ->map(function ($group, $key) {
                return PostSearchResultData::from([
                    'type' => $key,
                    'items' => $group,
                ]);
            })->values()->toArray();
    }

    public function extractAndOrganizeData(): void
    {
        $this->allItems = [];
        $this->reviewsItems = [];
        $this->postsItems = [];

        foreach ($this->searchResults as $result) {
            $type = $result['type'];
            $items = $result['items'];

            $this->allItems = array_merge($this->allItems, $items);

            if ($type === 'reviews') {
                $this->reviewsItems = array_merge($this->reviewsItems, $items);
            } elseif ($type === 'posts') {
                $this->postsItems = array_merge($this->postsItems, $items);
            }
        }
    }

    public function upVote(): void
    {
        $vote = Meta::where([
            'key' => 'votes',
            'model_id' => $this->postId,
            'model_type' => Post::class,
        ])->first();
        if ($vote) {
            $vote->content = (int) $vote->content + 1;
        } else {
            $vote = new Meta;
            $vote->key = 'votes';
            $vote->model_id = $this->postId;
            $vote->model_type = Post::class;
            $vote->content = 1;
        }
        $vote->save();
        $this->voted = true;
        $this->votes = $vote->content;
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }

    public function claim()
    {
    }

    public function mount(Post $post)
    {
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.global-search.global-search');
    }

    protected function queryString()
    {
        return [
            'inputTerm' => [
                'as' => 's',
                'history' => 'true',
            ],
        ];
    }
}

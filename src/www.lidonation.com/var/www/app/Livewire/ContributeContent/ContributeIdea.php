<?php

namespace App\Livewire\ContributeContent;

use App\Events\ContentIdeaContributed;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Scopes\LimitScope;
use App\Scopes\PublishedScope;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class ContributeIdea extends ModalComponent
{
    public $post;

    public $posts;

    public ?bool $submittingIdea = true;

    public ?bool $ideaSubmitted = false;

    protected $listeners = [
        'upvoteIdea' => 'upvoteIdea',
        'submitIdea' => 'submitIdea',
    ];

    // form
    public ?string $name = null;

    public ?string $email = null;

    public ?string $title = null;

    public ?string $social_excerpt = null;

    public ?string $comment_prompt = null;

    public ?string $author_comments = null;

    public ?string $idea = null;

    public ?string $link = null;

    public ?string $links = null;

    protected array $rules = [];

    public function upvoteIdea()
    {
        $this->submittingIdea = false;
    }

    public function submitIdea()
    {
        $this->ideaSubmitted = false;
        $this->submittingIdea = true;
    }

    public function saveIdea()
    {
        $this->rules['title'] = 'required|string|min:6';
        $this->rules['idea'] = 'required|string|max:2500';
        $this->validate();

        $post = new Post;
        $post->fill([
            'title' => $this->title,
            'status' => 'pending',
        ]);
        $post->save();
        collect([
            'submitted_by' => $this->name,
            'idea' => $this->idea,
            'author_email' => $this->email,
            'links' => $this->links,
        ])->filter()->each(fn ($meta, $key) => $post->saveMeta($key, $meta, $post));
        $this->reset();
        $this->ideaSubmitted = true;
        ContentIdeaContributed::dispatch($post);
    }

    public function reset(...$properties)
    {
        parent::reset($properties);
        $this->submittingIdea = false;
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function render(PostRepository $posts): Factory|View|Application
    {
        Post::withoutGlobalScopes([PublishedScope::class, LimitScope::class]);
        $this->posts = $posts->setQuery(Post::where('status', '!=', 'published'))
            ->all()
            ->map(fn ($p) => (new Post)->fill([
                'id' => $p->id,
                'title' => $p->title,
            ])
            )->sortByDesc('votes', SORT_NUMERIC);

        return view('livewire.contribute-content.contribute-idea');
    }
}

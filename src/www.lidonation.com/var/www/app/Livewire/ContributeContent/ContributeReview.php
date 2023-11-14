<?php

namespace App\Livewire\ContributeContent;

use App\Events\ContentContributed;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class ContributeReview extends ModalComponent
{
    public $post;

    public ?bool $submittingReview = false;

    public ?bool $reviewSubmitted = false;

    protected $listeners = [
        'submitArticle' => 'submitReview',
    ];

    // form
    public ?string $name = null;

    public ?string $email = null;

    public ?string $title = null;

    public ?string $social_excerpt = null;

    public ?string $comment_prompt = null;

    public ?string $author_comments = null;

    public ?string $article = null;

    public ?string $link = null;

    protected array $rules = [];

    public function submitReview()
    {
        $this->submittingReview = true;
        $this->submittingReview = false;
    }

    public function saveReview()
    {
        $this->rules['title'] = 'required|string|min:2';
        $this->rules['name'] = 'required|string|min:2';
        $this->rules['email'] = 'required|string';
        $this->rules['link'] = 'required|string|min:7';
        $this->validate();

        if (isset($this->post)) {
            $this->claimingArticle = true;
        }
        $post = $this->post ?? new Post;
        $post->fill([
            'title' => $this->title,
            'comment_prompt' => $this->comment_prompt,
            'social_excerpt' => $this->social_excerpt,
            'status' => 'draft',
        ]);
        $post->save();
        collect([
            'author_comments' => $this->author_comments,
            'author_email' => $this->email,
            'submitted_by' => $this->name,
            'link' => $this->link,
        ])->filter()->each(fn ($meta, $key) => $post->saveMeta($key, $meta, $post));
        $this->reset();
        ContentContributed::dispatch($post);
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function reset(...$properties)
    {
        parent::reset($properties);
        $this->reviewSubmitted = true;
        $this->submittingReview = false;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.contribute-content.contribute-review');
    }
}

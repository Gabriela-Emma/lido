<?php

namespace App\Http\Livewire\ContributeContent;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class ContributeRecording extends ModalComponent
{
    public ?array $posts = [];

    public ?Post $article = null;

    public ?bool $recordingComplete = false;

    public ?bool $recordingStarted = false;

    protected $listeners = [
        'startRecorder' => 'startRecorder',
        'submitArticle' => 'submitArticle',
        'recordingSubmitted' => 'recordingSubmitted',
    ];

    // form
    public ?string $name = null;

    public ?string $email = null;

    protected array $rules = [];

    public function unsetArticle(PostRepository $postRepository)
    {
        $this->posts = $postRepository->setQuery(Post::query()->unrecorded())
            ->models()
            ->all();
        $this->article = null;
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function startRecorder()
    {
        $this->recordingStarted = true;
    }

    public function recordingSubmitted()
    {
        $this->recordingComplete = true;
    }

    public function chooseArticle(Post $post)
    {
        $this->article = $post;
    }

    public function reset(...$properties)
    {
        $this->recordingComplete = false;
    }

    public function mount(Post $post, PostRepository $postRepository)
    {
        $this->article = $post;
        $this->posts = $postRepository->setQuery(Post::query()->unrecorded())
            ->models()
            ->all();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.contribute-content.contribute-recording');
    }
}

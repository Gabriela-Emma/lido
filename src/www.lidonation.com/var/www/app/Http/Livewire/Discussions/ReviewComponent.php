<?php

namespace App\Http\Livewire\Discussions;

use App\Models\Discussion;
use App\Models\Assessment;
use App\Repositories\CommentRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReviewComponent extends Component
{
    public bool $editable = true;

    public ?int $modelId = null;

    public ?int $parentId = null;

//    public ?string $prompt = null;
    public ?string $modelType = null;

    public ?bool $writing = false;

    public ?Discussion $discussion = null;

    public ?Assessment $review = null;

    public bool $replySubmitted = false;

    public ?string $comments = null;

    // form
    public ?string $name = null;

    public ?string $email = null;

    public ?string $title = null;

    protected $listeners = [
        'replyToReview' => 'replyToReview',
    ];

    protected array $rules = [];

    public function replyToReview(Assessment $comment)
    {
        $this->parentId = $comment->id;
        $this->modelType = $comment->model_type;
        $this->modelId = $comment->model_id;
    }

    public function reset(...$properties)
    {
        $this->writing = false;
    }

    public function writeReview()
    {
        $this->writing = true;
        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }
    }

    public function submitReview(CommentRepository $commentRepository)
    {
        if ($this->writing !== true) {
            return null;
        }

        $this->resetErrorBag();

        // comment context rules
        $this->rules['comments'] = 'required|string|min:7';

        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->comments ?? $this->model?->title,
            'model_id' => $this->modelId,
            'model_type' => $this->modelType,
            'parent_id' => $this->parentId,
        ];
        $data['meta'] = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        $this->replySubmitted = (bool) $commentRepository->create($data);
        $this->reset();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.discussions.review');
    }
}

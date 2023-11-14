<?php

namespace App\Livewire;

use App\Models\CatalystExplorer\Assessment;
use App\Models\Model;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentFormComponent extends Component
{
    public ?int $modelId = null;

    public ?int $parentId = null;

    public ?Model $model = null;

    public ?string $prompt = null;

    public ?string $context = 'comment';

    public ?string $modelType = null;

    public ?bool $commenting = false;

    public ?int $rating = null;

    public ?Assessment $comment = null;

    // form
    public ?string $name = null;

    public ?string $email = null;

    public ?string $title = null;

    public ?string $comments = null;

    protected $listeners = [
        'replyToComment' => 'replyToComment',
    ];

    public ?string $gRecaptchaResponse = null;

    public bool $commentSaved = false;

    protected array $rules = [];

    public function render()
    {
        return view('livewire.comment-form');
    }

    public function reset(...$properties)
    {
        parent::reset($properties);
        if (isset($this->comment)) {
            unset($this->comment);
        }
        $this->commenting = false;
    }

    public function replyToComment(Assessment $comment)
    {
        $this->reset();
        $this->parentId = $comment->id;
        $this->modelType = $comment->model_type;
        $this->modelId = $comment->model_id;
        $this->writeComment();
    }

    public function writeComment()
    {
        $this->commenting = true;
        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }
    }

    public function submitComment(CommentRepository $commentRepository)
    {
        if ($this->commenting !== true) {
            return null;
        }

        $this->resetErrorBag();

        // review context rules
        if ($this->context === 'review') {
            $this->rules['name'] = 'required|string|min:2';
            $this->rules['email'] = 'required|email';
            $this->rules['rating'] = 'required:min:1';
            if (! isset($this->model) || auth()?->user()?->id !== $this->model->user_id) {
                $this->rules['comments'] = 'required|string|min:7';
            }
        }

        // comment context rules
        if ($this->context !== 'review') {
            $this->rules['comments'] = 'required|string|min:7';
        }

        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->comments ?? $this->model?->title,
            'model_id' => $this->modelId,
            'model_type' => $this->modelType,
            'parent_id' => $this->parentId,
        ];
        if ($this->context === 'review') {
            $data['rating'] = [
                'rating' => $this->rating,
            ];
        }
        $data['meta'] = [
            'name' => $this->name,
            'email' => $this->email,
        ];
        $this->comment = $commentRepository->create($data);
        $this->commenting = false;
    }
}

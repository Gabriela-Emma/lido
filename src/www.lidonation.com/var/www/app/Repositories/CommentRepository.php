<?php

namespace App\Repositories;

use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Pure;

class CommentRepository extends Repository
{
    // Constructor to bind model to repo
    #[Pure]
    public function __construct(Assessment $model)
    {
        parent::__construct($model);
    }

       public function create(array $data): Assessment
       {
           $meta = null;
           if (isset($data['meta'])) {
               $meta = collect($data['meta']);
               unset($data['meta']);
           }

           $comment = new Assessment;
           $comment->title = $data['title'] ?? null;
           $comment->content = $data['content'];
           $comment->model_type = $data['model_type'];
           $comment->model_id = $data['model_id'];
           $comment->status = $data['status'] ?? null;

           if (Auth::check()) {
               $comment->status = 'published';
               $comment->user_id = auth()?->user()?->getAuthIdentifier();
           }

           if (isset($data['parent_id'])) {
               $comment->parent_id = $data['parent_id'];
           }
           $comment->save();

           if (isset($comment->parent_id)) {
               $comment->saveMeta('child_id', $comment->id, Assessment::find($comment->parent_id), false);
           }

           if (isset($data['rating'])) {
               $data['rating']['comment_id'] = $comment->id;
               $data['rating']['model_id'] = $data['model_id'];
               $data['rating']['model_type'] = $data['model_type'];
               app(RatingRepository::class)->create($data['rating']);
           }

           // Maybe save meta
           $meta?->each(
               fn ($meta, $key) => $comment->saveMeta($key, $meta, $comment)
           );

           return $comment;
       }
}

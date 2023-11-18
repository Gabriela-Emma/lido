<?php

use App\Models\Comment;
use App\Models\Meta;
use App\Models\ModelCategory;
use App\Models\ModelLink;
use App\Models\ModelSnippet;
use App\Models\Post;
use App\Models\ModelTag;
use App\Models\Prompt;
use App\Models\Reactions\Reaction;
use App\Models\Translation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

return new class extends Migration
{
    protected $directory = 'news_model_deprecation_tracker';
    protected $fileName = 'news_deprecation_changes.json';
    protected string $newsClass = "App\Models\News";
    protected $trackedChanges = [];
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Post::withoutGlobalScope(LimitScope::class);
        $newsColl = Post::where('type', $this->newsClass)
            ->get();

        // first rename type column from App\Models\News to App\Models\Post
        if (!$newsColl->isEmpty()) {
            $newsColl->each(function($news) {
                $news->type = Post::class;
                $newsTypeUpdated = $news->save();

                if ($newsTypeUpdated) {
                    $this->trackedChanges[$news->id]['type'] = [
                            'from' => $this->newsClass,
                            'to' => Post::class
                        ];
                }
            });

            // depracate categories
            $newsColl->each(function(Post $post) {
                $modelCategories = ModelCategory::where('model_id', $post->id)
                    ->where('model_type', $this->newsClass)
                    ->get();
                if (!$modelCategories->isEmpty()) {
                    $modelCategories->each(function(ModelCategory $modelCat) use($post) {
                        $modelCat->forceDelete();
                        $post->categories()->attach([$modelCat->category_id => [
                            'id' => $modelCat->id,
                            'model_type' => $post->type,
                            'model_id' => $post->id
                        ]]);

                        $updatedModelCategory = ModelCategory::find($modelCat->id);
                        if ($updatedModelCategory->model_type == $post->type) {
                            $this->trackedChanges[$post->id]['model_categories'][$updatedModelCategory->id] = [
                                    'column' => 'model_type', 
                                    'from' => $this->newsClass,
                                    'to' => $post->type
                                ];
                        } 
    
                    });
                }
            });

            // depracate tags
            $newsColl->each(function(Post $post) {
                $modelTags = ModelTag::where('model_id', $post->id)
                    ->where('model_type', $this->newsClass)
                    ->get();
                if (!$modelTags->isEmpty()) {
                    $modelTags->each(function(ModelTag $modelTag) use($post) {
                        $modelTag->forceDelete();
                        $post->tags()->attach([$modelTag->tag_id => [
                            'id' => $modelTag->id,
                            'model_type' => $post->type,
                            'model_id' => $post->id
                        ]]);

                        $updatedModelTag = ModelTag::find($modelTag->id);
                        if ($updatedModelTag->model_type == $post->type) {
                            $this->trackedChanges[$post->id]['model_tags'][$updatedModelTag->id] = [
                                    'column' => 'model_type', 
                                    'from' => $this->newsClass,
                                    'to' => $post->type
                                ];
                        } 
    
                    });
                }
            });
            
            // deprecate media
            $newsColl->each(function(Post $post) {
                $media = Media::where('model_id', $post->id)
                    ->where('model_type', $this->newsClass)
                    ->get();

                if (!$media->isEmpty()) {
                    $media->each(function(Media $media) use($post) {
                        $media->model_type = $post->type;
                        $media->save();

                        $updatedMedia = Media::find($media->id);
                        if($updatedMedia->model_type == $post->type) {
                            $this->trackedChanges[$post->id]['media'][$updatedMedia->id] = [
                                'column' => 'model_type', 
                                'from' => $this->newsClass,
                                'to' => $post->type
                            ];
                        }
                    });

                }
            });

            // deprecate reactions
            $newsColl->each(function(Post $post) {
                $reactions = Reaction::where('model_id', $post->id)
                    ->where('model_type', $this->newsClass)
                    ->get();

                if (!$reactions->isEmpty()) {
                    $reactions->each(function(Reaction $reaction) use($post) {
                        $reaction->model_type = $post->type;
                        $reaction->save();

                        $updatedReaction = Reaction::find($reaction->id);
                        if($updatedReaction->model_type == $post->type) {
                            $this->trackedChanges[$post->id]['reactions'][$updatedReaction->id] = [
                                'column' => 'model_type', 
                                'from' => $this->newsClass,
                                'to' => $post->type
                            ];
                        }
                    });

                }
            });

            // deprecate comments
            $newsColl->each(function(Post $post) {
                $comments = Comment::where('commentable_id', $post->id)
                    ->where('commentable_type', $this->newsClass)
                    ->get();

                if (!$comments->isEmpty()) {
                    $comments->each(function(Comment $comment) use($post) {
                        $comment->commentable_type = $post->type;
                        $comment->save();

                        $updatedComment = Comment::find($comment->id);
                        if($updatedComment->commentable_type == $post->type) {
                            $this->trackedChanges[$post->id]['comments'][$updatedComment->id] = [
                                'column' => 'commentable_type', 
                                'from' => $this->newsClass,
                                'to' => $post->type
                            ];
                        }
                    });

                }
            });

            // deprecate model_links
            $newsColl->each(function(Post $post) {
                $modelLinks = ModelLink::where('model_id', $post->id)
                    ->where('model_type', $this->newsClass)
                    ->get();
                if (!$modelLinks->isEmpty()) {
                    $modelLinks->each(function(ModelLink $modelLink) use($post) {
                        $modelLink->forceDelete();
                        $post->links()->attach([$modelLink->link_id => [
                            'id' => $modelLink->id,
                            'model_type' => $post->type,
                            'model_id' => $post->id
                        ]]);

                        $updatedModelLink = ModelLink::find($modelLink->id);
                        if ($updatedModelLink->model_type == $post->type) {
                            $this->trackedChanges[$post->id]['model_links'][$updatedModelLink->id] = [
                                    'column' => 'model_type', 
                                    'from' => $this->newsClass,
                                    'to' => $post->type
                                ];
                        } 
    
                    });
                }
            });

            // deprecate metas
            $newsColl->each(function(Post $post) {
                $metas = Meta::where('model_id', $post->id)
                    ->where('model_type', $this->newsClass)
                    ->get();

                if (!$metas->isEmpty()) {
                    $metas->each(function(Meta $meta) use($post) {
                        $meta->model_type = $post->type;
                        $meta->save();

                        $updatedMeta = Meta::find($meta->id);
                        if($updatedMeta->model_type == $post->type) {
                            $this->trackedChanges[$post->id]['metas'][$updatedMeta->id] = [
                                'column' => 'model_type', 
                                'from' => $this->newsClass,
                                'to' => $post->type
                            ];
                        }
                    });

                }
            });

            // deprecate prompts
            $newsColl->each(function(Post $post) {
                $prompts = Prompt::where('model_id', $post->id)
                    ->where('model_type', $this->newsClass)
                    ->whereNull('parent_id')
                    ->get();

                if (!$prompts->isEmpty()) {
                    $prompts->each(function(Prompt $prompt) use($post) {
                        $prompt->model_type = $post->type;
                        $prompt->save();

                        $updatedPrompt = Prompt::find($prompt->id);
                        if($updatedPrompt->model_type == $post->type) {
                            $this->trackedChanges[$post->id]['prompts'][$updatedPrompt->id] = [
                                'column' => 'model_type', 
                                'from' => $this->newsClass,
                                'to' => $post->type
                            ];
                        }
                    });

                }
            });

            // deprecate model_snippets
            $newsColl->each(function(Post $post) {
                $modelSnippets = ModelSnippet::where('model_id', $post->id)
                    ->where('model_type', $this->newsClass)
                    ->get();
                if (!$modelSnippets->isEmpty()) {
                    $modelSnippets->each(function(ModelSnippet $modelSnippet) use($post) {
                        $modelSnippet->forceDelete();
                        $post->snippets()->attach([$modelSnippet->snippet_id => [
                            'id' => $modelSnippet->id,
                            'model_type' => $post->type,
                            'model_id' => $post->id
                        ]]);

                        $updatedModelSnippet = ModelSnippet::find($modelSnippet->id);
                        if ($updatedModelSnippet->model_type == $post->type) {
                            $this->trackedChanges[$post->id]['model_snippets'][$updatedModelSnippet->id] = [
                                    'column' => 'model_type', 
                                    'from' => $this->newsClass,
                                    'to' => $post->type
                                ];
                        } 
    
                    });
                }
            });

            // deprecate translations
            $newsColl->each(function(Post $post) {
                $translations = Translation::where('source_id', $post->id)
                    ->where('source_type', $this->newsClass)
                    ->get();
                
                if (!$translations->isEmpty()) {
                    $translations->each(function(Translation $translation) use($post) {
                        $translation->source_type = $post->type;
                        $translation->save();

                        $updatedTranslation = Translation::find($translation->id);
                        if($updatedTranslation->source_type == $post->type) {
                            $this->trackedChanges[$post->id]['translations'][$updatedTranslation->id] = [
                                'column' => 'source_type', 
                                'from' => $this->newsClass,
                                'to' => $post->type
                            ];
                        }
                    });

                }
            });   
        }


        $fileStoragePath = $this->directory.'/'.$this->fileName;
        $fileFullPath = Storage::path($fileStoragePath);
    
        // if a tracking file already exists then delete it
        $fileExists = Storage::exists($fileStoragePath);
        if ($fileExists) {
            File::delete($fileFullPath);
        }

        // Write JSON trackedChanges to a file
        $jsonData = json_encode($this->trackedChanges);
        Storage::put($fileStoragePath, $jsonData);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $fileStoragePath = $this->directory.'/'.$this->fileName;
        $fileFullPath = Storage::path($fileStoragePath);

        // fetch the trackedChanges from the saved file
        $trackedData = Storage::get($fileStoragePath);
        $trackedJsonData = json_decode($trackedData);

        foreach ($trackedJsonData as $key => $value) {
            $post = Post::find($key);
            
            // revert post type column to news
            $post->type = $trackedJsonData?->$key->type->from;
            $post->save();

            // revert categories
            if ($trackedJsonData?->$key->model_categories ?? false) {
                foreach($trackedJsonData->$key->model_categories as $id => $value) {
                    $mc = ModelCategory::find($id);
                    $mc->forceDelete();

                    $post->categories()->attach([$mc->category_id => [
                        'id' => $mc->id,
                        $value->column => $value->from,
                        'model_id' => $post->id
                    ]]);
                }
            }

            // revert tags
            if ($trackedJsonData?->$key->model_tags ?? false) {
                foreach($trackedJsonData->$key->model_tags as $id => $value) {
                    $t = ModelTag::find($id);
                    $t->forceDelete();
                    
                    $post->tags()->attach([$t->tag_id => [
                        'id' => $t->id,
                        $value->column => $value->from,
                        'model_id' => $post->id
                    ]]);
                }
            }

            // revert media
            if ($trackedJsonData?->$key->media ?? false) {
                foreach($trackedJsonData->$key->media as $id => $value) {
                    $m = Media::find($id);
                    $m->{$value->column} = $value->from;

                    $m->save();
                }
            }

            // revert reactions
            if ($trackedJsonData?->$key->reactions ?? false) {
                foreach($trackedJsonData->$key->reactions as $id => $value) {
                    $reaction = Reaction::find($id);
                    $reaction->{$value->column} = $value->from;

                    $reaction->save();
                }
            }   

            // revert comments
            if ($trackedJsonData?->$key->comments ?? false) {
                foreach($trackedJsonData->$key->comments as $id => $value) {
                    $comment = Comment::find($id);
                    $comment->{$value->column} = $value->from;

                    $comment->save();

                }
            }

            // revert links
            if ($trackedJsonData?->$key->model_links ?? false) {
                foreach($trackedJsonData->$key->model_links as $id => $value) {
                    $link = ModelLink::find($id);
                    $link->forceDelete();

                    $post->links()->attach([$link->link_id => [
                        'id' => $link->id,
                        $value->column => $value->from,
                        'model_id' => $post->id
                    ]]);

                }
            }

            // revert metas
            if ($trackedJsonData?->$key->metas ?? false) {
                foreach($trackedJsonData->$key->metas as $id => $value) {
                    $meta = Meta::find($id);
                    $meta->{$value->column} = $value->from;

                    $meta->save();
                }
            }

            // revert prompts
            if ($trackedJsonData?->$key->prompts ?? false) {
                foreach($trackedJsonData->$key->prompts as $id => $value) {
                    $prompt = Prompt::find($id);
                    $prompt->{$value->column} = $value->from;

                    $prompt->save();
                }
            }

            // revert snippets
            if ($trackedJsonData?->$key->model_snippets ?? false) {
                foreach($trackedJsonData->$key->model_snippets as $id => $value) {
                    $snippet = ModelSnippet::find($id);
                    $snippet->forceDelete();

                    $post->snippets()->attach([$snippet->snippet_id => [
                        'id' => $snippet->id,
                        $value->column => $value->from,
                        'model_id' => $post->id
                    ]]);
                }
            }

            // revert translations
            if ($trackedJsonData?->$key->translations ?? false) {
                foreach($trackedJsonData->$key->translations as $id => $value) {
                    $translation = Translation::find($id);
                    $translation->{$value->column} = $value->from;

                    $translation->save();
                }
            }
        }

        // delete the directory where we are tracking these changes
        File::delete($fileFullPath);
        Storage::deleteDirectory($this->directory);
    }
};

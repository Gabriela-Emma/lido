<?php

namespace App\Models\Reactions;

use App\Models\User;
use App\Enums\ReactionEnum;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasReactions {
    public function lido_reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'model');
    }

    public function addLidoReaction(string $reaction, User $commenter = null): void
    {
        $existingReaction = $this->lido_reactions()
            ->where('reaction', $reaction)
            ->where('commenter_id', optional($commenter)->id ?: auth()->id())
            ->where('model_type', get_class($this))
            ->where('model_id', $this->id)
            ->first();

        if ($existingReaction) {
            throw new \Exception('This reaction exists for this user in this model.');
        }

        $oneReactionPerModel = $this->lido_reactions()
            ->where('commenter_id', optional($commenter)->id ?: auth()->id())
            ->where('model_type', get_class($this))
            ->where('model_id', $this->id)
            ->count();

        if ($oneReactionPerModel > 0) {
            throw new \Exception('User can only create one reaction per model.');
        }

        $type = ReactionEnum::getClass($reaction);

        if (!$existingReaction && !$oneReactionPerModel) {
            $this->lido_reactions()->create([
                'reaction' => $reaction,
                'type' => "$type",
                'commenter_id' => optional($commenter)->id ?: auth()->id(),
                'commenter_type' => $commenter ? get_class($commenter) : User::class,
            ]);
        }
    }

    public function hearts() {
        return $this->hasMany(ReactionHeart::class, 'model_id')
            ->where('type', ReactionHeart::class);
    }

    public function eyes() {
        return $this->hasMany(ReactionEyes::class, 'model_id')
            ->where('type', ReactionEyes::class);
    }
    
    public function party_popper() {
        return $this->hasMany(ReactionPartyPopper::class, 'model_id')
            ->where('type', ReactionPartyPopper::class);
    }

    public function rocket() {
        return $this->hasMany(ReactionRocket::class, 'model_id')
            ->where('type', ReactionRocket::class);
    }

    public function thumbs_down() {
        return $this->hasMany(ReactionThumbsDown::class, 'model_id')
            ->where('type', ReactionThumbsDown::class);
    }

    public function thumbs_up() {
        return $this->hasMany(ReactionThumbsUp::class, 'model_id')
            ->where('type', ReactionThumbsUp::class);
    }
}

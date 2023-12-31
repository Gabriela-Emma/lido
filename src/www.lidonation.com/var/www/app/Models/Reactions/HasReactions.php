<?php

namespace App\Models\Reactions;

use App\Enums\ReactionEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasReactions
{
    public function lido_reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'model');
    }

    public function addLidoReaction(string $reaction, User $commenter = null): void
    {
        $existingReaction = null;

        if ($commenter !== null) {
            $existingReaction = $this->lido_reactions()
                ->where('reaction', $reaction)
                ->where('commenter_id', optional($commenter)->id ?: auth()->id())
                ->where('model_type', get_class($this))
                ->where('model_id', $this->id)
                ->first();

            if ($existingReaction) {
                throw new \Exception('This reaction exists for this user in this model.');
            }
        }

        $type = ReactionEnum::getClass($reaction);

        if (! $existingReaction) {
            $this->lido_reactions()->create([
                'reaction' => $reaction,
                'type' => "$type",
                'commenter_id' => optional($commenter)->id ?: null,
                'commenter_type' => $commenter ? get_class($commenter) : User::class,
            ]);
        }
    }

    public function heart()
    {
        return $this->hasMany(ReactionHeart::class, 'model_id')
            ->where('type', ReactionHeart::class);
    }

    public function eye()
    {
        return $this->hasMany(ReactionEye::class, 'model_id')
            ->where('type', ReactionEye::class);
    }

    public function party_popper()
    {
        return $this->hasMany(ReactionPartyPopper::class, 'model_id')
            ->where('type', ReactionPartyPopper::class);
    }

    public function rocket()
    {
        return $this->hasMany(ReactionRocket::class, 'model_id')
            ->where('type', ReactionRocket::class);
    }

    public function thumbs_down()
    {
        return $this->hasMany(ReactionThumbsDown::class, 'model_id')
            ->where('type', ReactionThumbsDown::class);
    }

    public function thumbs_up()
    {
        return $this->hasMany(ReactionThumbsUp::class, 'model_id')
            ->where('type', ReactionThumbsUp::class);
    }
}

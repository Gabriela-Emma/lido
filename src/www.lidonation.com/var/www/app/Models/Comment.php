<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Spatie\Comments\Exceptions\CannotSendPendingCommentNotification;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use Spatie\Comments\Models\Reaction;
use Spatie\Comments\Notifications\PendingCommentNotification;

class Comment extends \Spatie\Comments\Models\Comment
{
    protected $with = [
        'commentator'
    ];

//    public array $translatable = [
//        'text'
//    ];

    public function react(string $reaction, CanComment $commentator = null): self
    {
        $commentator ??= auth()->user();

        $this->reactions()->firstOrCreate([
            'commentator_id' => $commentator?->getKey(),
            'commentator_type' => $commentator?->getMorphClass(),
            'reaction' => $reaction,
        ]);

        return $this;
    }

    public function findReaction(string $reaction, CanComment $commentator = null): ?Reaction
    {
        $commentator ??= auth()->user();

        return $this->reactions()
            ->where('commentator_id', $commentator?->getKey())
            ->where('commentator_type', $commentator?->getMorphClass())
            ->where('reaction', $reaction)
            ->first();
    }

    public function getApprovingUsers(): Collection
    {
        $sendToClosure = PendingCommentNotification::$sendTo;

        if (! $sendToClosure) {
            return collect([]);
        }

        $users = once(fn () => $sendToClosure($this));

        if (is_iterable($users)) {
            $users = collect($users)
                ->each(function (object $user) {
                    if (! self::implementsNotifiable($user)) {
                        throw CannotSendPendingCommentNotification::doesNotImplementNotifiable();
                    }
                });

            return $users;
        }

        if (is_object($users)) {
            if (! self::implementsNotifiable($users)) {
                throw CannotSendPendingCommentNotification::doesNotImplementNotifiable();
            }

            return collect([$users]);
        }

        throw CannotSendPendingCommentNotification::doesNotImplementNotifiable();
    }

    public function shouldBeAutomaticallyApproved(): bool
    {
        // $this->commentator is the user that created the comment
        if ($this->commentator?->created_at?->diffInMonths() < 3) {
            return false;
        }

        // automatically approve the comment is the user that
        // created the comment can also approve it
        return $this->getApprovingUsers()->contains(auth()->user());
    }

    /**
     * Get parent post to a comment
     */
    public function parent()
    {
        return $this->morphTo('commentable');
    }
}

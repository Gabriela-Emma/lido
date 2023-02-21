<?php

namespace App\Providers;

use App\Models\AnswerResponse;
use App\Models\Assessment;
use App\Models\CatalystGroup;
use App\Models\Category;
use App\Models\Cause;
use App\Models\Comment;
use App\Models\Definition;
use App\Models\Discussion;
use App\Models\ExternalPost;
use App\Models\Fund;
use App\Models\Insight;
use App\Models\News;
use App\Models\OnboardingContent;
use App\Models\Post;
use App\Models\Prompt;
use App\Models\Proposal;
use App\Models\Question;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Rule;
use App\Models\Snippet;
use App\Models\Tag;
use App\Models\Translation;
use App\Models\Tx;
use App\Models\User;
use App\Models\Wallet;
use App\Observers\AnswerResponseObserver;
use App\Observers\CatalystGroupObserver;
use App\Observers\CategoryObserver;
use App\Observers\CauseObserver;
use App\Observers\CommentObserver;
use App\Observers\DefinitionObserver;
use App\Observers\DiscussionObserver;
use App\Observers\FundObserver;
use App\Observers\LegacyCommentObserver;
use App\Observers\PostObserver;
use App\Observers\ProposalObserver;
use App\Observers\QuestionObserver;
use App\Observers\RatingObserver;
use App\Observers\RuleObserver;
use App\Observers\SnippetObserver;
use App\Observers\TagObserver;
use App\Observers\TranslationObserver;
use App\Observers\TxObserver;
use App\Observers\UserObserver;
use App\Observers\WalletObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\Comments\Notifications\PendingCommentNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        AnswerResponse::observe(AnswerResponseObserver::class);
        Cause::observe(CauseObserver::class);
        Category::observe(CategoryObserver::class);
        CatalystGroup::observe(CatalystGroupObserver::class);
        Comment::observe(CommentObserver::class);
        Assessment::observe(LegacyCommentObserver::class);
        Definition::observe(DefinitionObserver::class);
        Discussion::observe(DiscussionObserver::class);
        Fund::observe(FundObserver::class);
        Insight::observe(PostObserver::class);
        News::observe(PostObserver::class);
        OnboardingContent::observe(PostObserver::class);
        Post::observe(PostObserver::class);
        ExternalPost::observe(PostObserver::class);
        Proposal::observe(ProposalObserver::class);
        Prompt::observe(LegacyCommentObserver::class);
        Question::observe(QuestionObserver::class);
        Rating::observe(RatingObserver::class);
        Review::observe(PostObserver::class);
        Snippet::observe(SnippetObserver::class);
        Tag::observe(TagObserver::class);
        Translation::observe(TranslationObserver::class);
        Tx::observe(TxObserver::class);
        User::observe(UserObserver::class);
        Wallet::observe(WalletObserver::class);
        Rule::observe(RuleObserver::class);

        PendingCommentNotification::sendTo(function (Comment $comment) {
            return User::role(['admin', 'super admin'])->get(); // select some users
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}

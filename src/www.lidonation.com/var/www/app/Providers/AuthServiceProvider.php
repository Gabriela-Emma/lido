<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Team;
use App\Models\Event;
use App\Models\Comment;
use App\Models\Proposal;
use App\Models\Assessment;
use App\Models\Definition;
use App\Models\Discussion;
use App\Models\Translation;
use App\Models\BookmarkItem;
use App\Models\CatalystUser;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use App\Policies\TeamPolicy;
use App\Models\CatalystGroup;
use App\Policies\EventPolicy;
use App\Policies\MediaPolicy;
use App\Policies\CommentPolicy;
use App\Policies\ProposalPolicy;
use App\Models\BookmarkCollection;
use App\Policies\DefinitionPolicy;
use App\Policies\DiscussionPolicy;
use App\Policies\PermissionPolicy;
use Spatie\Permission\Models\Role;
use App\Policies\TranslationPolicy;
use App\Policies\BookmarkItemPolicy;
use App\Policies\CatalystUserPolicy;
use App\Policies\CatalystGroupPolicy;
use App\Policies\LegacyCommentPolicy;
use Spatie\Permission\Models\Permission;
use App\Policies\BookmarkCollectionPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        CatalystGroup::class => CatalystGroupPolicy::class,
        CatalystUser::class => CatalystUserPolicy::class,
        Comment::class => CommentPolicy::class,
        Discussion::class => DiscussionPolicy::class,
        Definition::class => DefinitionPolicy::class,
        Event::class => EventPolicy::class,
        Assessment::class => LegacyCommentPolicy::class,
        Media::class => MediaPolicy::class,
        Permission::class => PermissionPolicy::class,
        Post::class => PostPolicy::class,
        Proposal::class => ProposalPolicy::class,
        Role::class => RolePolicy::class,
        Team::class => TeamPolicy::class,
        BookmarkCollection::class => BookmarkCollectionPolicy::class,

        //        LanguageLine::class => LanguageLinePolicy::class,
        //        \Spatie\TranslationLoader\LanguageLine::class => LanguageLinePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return config('app.url').'/reset-password/'.$token;
        });
    }
}

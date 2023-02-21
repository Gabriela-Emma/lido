<?php

namespace App\Providers;

use App\Models\CatalystGroup;
use App\Models\CatalystUser;
use App\Models\Comment;
use App\Models\Definition;
use App\Models\Discussion;
use App\Models\Event;
use App\Models\Assessment;
use App\Models\Post;
use App\Models\Proposal;
use App\Models\Team;
use App\Models\Translation;
use App\Policies\CatalystGroupPolicy;
use App\Policies\CatalystUserPolicy;
use App\Policies\CommentPolicy;
use App\Policies\DefinitionPolicy;
use App\Policies\DiscussionPolicy;
use App\Policies\EventPolicy;
use App\Policies\LegacyCommentPolicy;
use App\Policies\MediaPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PostPolicy;
use App\Policies\ProposalPolicy;
use App\Policies\RolePolicy;
use App\Policies\TeamPolicy;
use App\Policies\TranslationPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        Translation::class => TranslationPolicy::class,

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

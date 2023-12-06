<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     */
    //    protected $rootView = 'layouts/catalyst-explorer';

    public function rootView(Request $request): string
    {
        return match ($request->segment(2)) {
            'catalyst-explorer' => 'layouts/catalyst-explorer',
            'earn' => 'layouts/earn',
            'rewards' => 'layouts/rewards',
            'delegators' => 'layouts/delegators',
            's' => 'layouts/lido-search',
            default => parent::rootView($request)
        };
    }

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        /** @var  User $user */
        $user = auth()->user()
            ?->only('id', 'name', 'email', 'bio', 'git', 'discord', 'linkedin', 'telegram', 'twitter', 'profile_photo_url');
        if ($user) {
            $user['roles'] = auth()->user()?->getRoleNames();
        }

        return [
            ...parent::share($request),
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
                'user' => fn () => $user ?? null,
                'locale' => app()->getLocale(),
                'asset_url' => asset('/'),
                'base_url' => config('app.url'),
            ],
        ];
    }
}

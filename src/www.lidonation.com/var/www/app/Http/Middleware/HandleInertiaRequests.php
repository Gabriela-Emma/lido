<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
//    protected $rootView = 'layouts/catalyst-explorer';

    public function rootView(Request $request)
    {
        return match ($request->segment(2)) {
            'catalyst-explorer' => 'layouts/catalyst-explorer',
            'earn' => 'layouts/earn',
            'rewards' => 'layouts/rewards',
            default => 'layout/app'
        };
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        $user = $request->user()
            ->only('id', 'name', 'email', 'bio', 'git', 'discord', 'linkedin', 'telegram', 'twitter');
        $user['roles'] = $request->user()->getRoleNames();

        return array_merge(parent::share($request), [
            'user' => fn () => $request->user() ? $user : null,
            'locale' => app()->getLocale(),
            'asset_url' => asset('/'),
            'base_url' => config('app.url'),
        ]);
    }
}

<?php

namespace App\Invokables;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class GetLidoMenu
{
    public function __invoke($menu = null): Collection
    {
        return collect($menu ?? config('menu'))->map(function ($menu) {
            $menu->items = $this->processMenuItems(collect($menu->items));

            return $menu;
        });
    }

    protected function processMenuItems(Collection $menu): Collection
    {
        return $menu->map(function ($m) {
            if ($m->items) {
                $m->items = $this->processMenuItems(collect($m->items));

                return $m;
            }
            $m->route = match ($m->route_type) {
                'post_id_or_slug' => (intval($m->route) > 0 ? Post::where('id', $m->route) : Post::where('slug', $m->route))?->first()?->link,
                'cat_id_or_slug' => (intval($m->route) > 0 ? Category::where('id', $m->route) : Category::where('slug', $m->route))?->first()?->url,
                'route_name' => Route::has($m->route) ? localizeRoute($m->route) : '',
                default => url($m->route ?? '')
            };

            return $m;
        });
    }
}

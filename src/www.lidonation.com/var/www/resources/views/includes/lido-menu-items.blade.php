<!-- includes/lido-menu-items.blade.php -->
<div class="menu-items-wrapper break-inside-avoid mb-8">
    <h3 class="text-base font-bold text-teal-600 w-44 truncate">
        {{$menu?->title}}
    </h3>
    @isset($menu?->items)
        <ul role="list" class="space-y-1 menu-items">
            @foreach($menu?->items as $menuItem)
                @isset($menuItem->items)
                    @include('includes.lido-menu-items', ['menu' => $menuItem])
                @else
                    @isset($menuItem->auth)
                        @auth()
                            @include('includes.lido-menu-item', ['menu' => $menuItem])
                        @endauth
                    @else
                        @isset($menuItem->guest)
                            @guest()
                                @include('includes.lido-menu-item', ['menu' => $menuItem])
                            @endguest
                        @else
                            @include('includes.lido-menu-item', ['menu' => $menuItem])
                        @endisset
                    @endisset
                @endisset
            @endforeach
        </ul>
    @endisset
</div>

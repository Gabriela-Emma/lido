<div class="menu-items-wrapper break-inside-avoid mb-8">
    <h3 class="text-base font-bold text-teal-600 w-44 truncate">
        {{$menu?->title}}
    </h3>
    @isset($menu?->items)
        <ul role="list" class="space-y-1 menu-items">
            @foreach($menu?->items as $menu)
                @isset($menu->items)
                    @include('includes.lido-menu-items')
                @else
                    @isset($menu->auth)
                        @auth()
                            @include('includes.lido-menu-item')
                        @endauth
                    @else
                        @isset($menu->guest)
                            @guest()
                                @include('includes.lido-menu-item')
                            @endguest
                        @else
                            @include('includes.lido-menu-item')
                        @endisset
                    @endisset
                @endisset
            @endforeach
        </ul>
    @endisset
</div>


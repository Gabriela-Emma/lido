<div class="menu-items-wrapper">
    <h3 class="text-base font-bold text-teal-600">
        {{$menu?->title}}
    </h3>
    @isset($menu?->items)
        <ul role="list" class="space-y-1 menu-items">
            @foreach($menu?->items as $menu)
                @isset($menu->items)
                    @include('includes.lido-menu-items')
                @else
                    <li class="flow-root menu-item">
                        <a href="{{$menu->route}}" title="{{$menu->title}}"
                           class="flex items-center text-base font-medium text-gray-900 transition duration-150 ease-in-out hover:text-teal-800">
                            {{$menu->title}}
                        </a>
                    </li>
                @endisset
            @endforeach
        </ul>
    @endisset
</div>


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
                    <li class="flow-root menu-item">
                        <a href="{{$menu->route}}" title="{{$menu->title}}" {{ $menu->title  === 'Weekly Townhall' ? 'target=_blank' : '' }}"
                           class="inline-flex items-center text-xs md:text-base font-medium text-gray-900 transition duration-150 ease-in-out hover:text-teal-800 {{\Illuminate\Support\Str::slug($menu->title)}}">
                            <span class="inline-block">{{$menu->title}}</span>
                        </a>
                     </li>
                @endisset
            @endforeach
        </ul>
    @endisset
</div>


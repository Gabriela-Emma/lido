<li class="flow-root menu-item">
    <a href="{{$menu->route}}" title="{{$menu->title}}" {{ $menu->title  === 'Weekly Townhall' ? 'target=_blank' : '' }}"
    class="inline-flex items-center text-xs md:text-base font-medium text-gray-900 transition duration-150 ease-in-out hover:text-teal-800 {{\Illuminate\Support\Str::slug($menu->title)}}">
    <span class="inline-block">{{$menu->title}}</span>
    </a>
</li>

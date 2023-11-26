<!-- includes/lido-menu-item.blade.php -->
<li class="flow-root menu-item">
    @if($menu->navigate === 'livewire')
        <a href="{{$menu->route}}"
           title="{{$menu->title}}"
           @if($menu->eager) wire:navigate.hover 
           @endif
           target="{{$menu->target ?? '_self'}}"
           class="inline-flex items-center text-xs md:text-base font-medium text-gray-900 transition duration-150 ease-in-out hover:text-teal-800 {{\Illuminate\Support\Str::slug($menu->title)}}">
            <span class="inline-block">{{$menu->title}}</span>
        </a>
    @else
        <a href="{{$menu->route}}"
           title="{{$menu->title}}"
           target="{{$menu->target ?? '_self'}}"
           class="inline-flex items-center text-xs md:text-base font-medium text-gray-900 transition duration-150 ease-in-out hover:text-teal-800 {{\Illuminate\Support\Str::slug($menu->title)}}">
            <span class="inline-block">{{$menu->title}}</span>
        </a>
    @endif
</li>

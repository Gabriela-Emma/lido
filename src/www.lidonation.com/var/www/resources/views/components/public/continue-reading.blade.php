@props([
    'link', 'route',
    'style' => 'link',
    'theme' => 'gray',
    'linkClasses' => '',
    'text' => $snippets->continueReading,
    'query'=> ''
    ])
<span {{$attributes->merge(['class' => 'my-2 mt-auto pt-4 inline-block'])}}>
    @switch($style)
        @case('button')
        <a href="{{strlen($query)>0 ? route($route,$query) : $link ?? route($route)}}" type="button"
            class="flex w-full items-center px-6 py-3 border border-{{$theme}}-300 font-medium rounded-sm text-gray-700 bg-white hover:bg-{{$theme}}-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 {{$linkClasses}}">
                <span>{{$text}}</span>
                <span class="ml-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </span>
            </a>
        @break
        @default
        <a href="{{strlen($query)>0 ? route($route,$query) : $link ?? route($route)}}" class="flex flex-row text-{{$theme}}-600 items-center w-full">
                <span>{{$text}}</span>
                <span class="ml-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </span>
            </a>
    @endswitch
</span>

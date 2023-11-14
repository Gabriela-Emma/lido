@props([
    'links'
])
@if($links && $links->isNotEmpty())
<div class="max-w-6xl xl:mx-auto flex flex-col my-8">
    <h2>Related Links</h2>
    <div>
        <ul role="list" class="border border-gray-300 rounded-sm divide-y divide-gray-300">
            @foreach($links as $link)
                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                    <div class="w-0 flex-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        <div class="ml-2 flex-1 flex flex-row flex-wrap items-center gap-x-3">
                                            <span class="font-medium text-lg">
                                              {{$link->title}}
                                            </span>
                            <span class="text-gray-400">
                                              {{$link->label}}
                                            </span>
                        </div>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <a target="_blank" rel="nofollow" href="{{$link->link}}" class="font-medium text-teal-600 hover:text-teal-600">
                            Visit
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif

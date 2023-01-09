@props([
    'index' => null,
     'post'
    ])
<div class="flex flex-col rounded-sm overflow-hidden">
    <div class="flex-shrink-0">
        <a href="{{$post->link}}">
            <img class="h-75 w-full object-cover"
                 src="{{$post->hero?->getUrl()}}" alt="{{$post->hero?->name}}"/>
        </a>
    </div>
    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
        <div class="flex-1">
            <a href="{{$post->link}}" class="block mt-2">
                <p class="text-xl font-semibold text-gray-900">
                    {{$post->title}}
                </p>
                <x-public.post-meta :post="$post"></x-public.post-meta>
                <p class="mt-3 text-base text-gray-500">
                    {{$post->summary}}
                </p>
            </a>
        </div>
        <div class="mt-6 flex items-center">
            <div class="flex-shrink-0">
                @if($index)
                    <p class="flex flex-row justify-center items-center h-16 w-16 rounded-full border inline-block">
                        <span class="text-sm font-medium text-2xl 2xl:text-4xl text-gray-900">{{$index}}</span>
                    </p>
                @else
                    <a href="#">
                        <span class="sr-only">{{$post->author->name}}</span>
                        <img class="h-10 w-10 rounded-full"
                             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixqx=zFtACK6hzK&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                             alt="picture"
                        >
                    </a>
                @endif
            </div>
            <div class="ml-3">
                @if(!$index)
                    <p class="text-sm font-medium text-gray-900">
                        <a href="#" class="hover:underline">
                            Roel Aufderehar
                        </a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

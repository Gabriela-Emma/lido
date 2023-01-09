@props(['index', 'orientation', 'post'])
<div class="relative flex flex-row w-full">
@if($orientation === 'left')
    <!-- content col -->
        <div class="w-10/12 md:w-5/6 px-2 p-10 z-10">
            <div
                class="flex flex-col lg:flex-row w-full rounded-sm border border-gray-300 bg-white p-5">
                @if($post->hero)
                    <div class="w-full min-w-full lg:min-w-2/5 xl:min-w-2/6">
                        <a href="{{$post->link}}">
                            <img class="img-fluid" width='640' height="640"
                                 src="{{$post->hero?->getUrl()}}" alt="{{$post->hero?->name}}"/>
                        </a>
                    </div>
                @endif
                <div class="py-5 lg:p-5 lg:pt-0">
                    <div class="mb-2 flex justify-between">
                        <div class="font-bold">
                            <a href="{{$post->link}}"
                               class="hover:text-teal-600">
                                {{$post->title}}
                            </a>
                            <x-public.post-meta :post="$post"></x-public.post-meta>
                        </div>
                    </div>
                    <div class="text-gray-600">
                        {{$post->summary}}

                        <div>
                            <a href="{{$post->link}}"
                               class="text-base font-semibold text-teal-600 hover:text-teal-600">
                                Read full article
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--line column-->
        <div
            class="absolute flex h-full w-px bg-gray-200 left-1/2 z-0 justify-center"></div>
        <!--index column-->
        <div
            class="w-2/12 md:w-2/5 px-2 py-10 flex flex-row h-full h-inherit items-enter content-end">
            <div
                class="hidden md:inline-flex text-8xl md:text-10xl leading-16 items-center text-gray-100 text-center mx-auto">{{$index}}</div>
        </div>
@else
    <!-- index col -->
        <div
            class="w-2/12 md:w-2/5 px-2 py-10 flex flex-row h-full h-inherit items-enter content-end">
            <div
                class="hidden md:inline-flex text-8xl md:text-10xl leading-16 text-gray-100 items-center text-center mx-auto">
                {{$index}}
            </div>
        </div>
        <!--line column-->
        <div
            class="absolute flex h-full w-px bg-gray-200 left-1/2 z-0 justify-center"></div>
        <!--content column-->
        <div class="w-10/12 md:w-5/6 px-2 py-10 z-10">
            <div
                class="flex flex-col lg:flex-row w-full rounded-sm border border-gray-300 bg-white px-4 py-5">
                @if($post->hero)
                    <div class="w-full min-w-full lg:min-w-2/5 xl:min-w-2/6">
                        <a href="{{$post->link}}">
                            <img class="img-fluid" width='640' height="640"
                                 src="{{$post->hero?->getUrl()}}" alt="{{$post->hero?->name}}"/>
                        </a>
                    </div>
                @endif
                <div class="py-5 lg:p-5 lg:pt-0">
                    <div class="mb-2 flex justify-between">
                        <div class="font-bold">
                            <a href="{{$post->link}}"
                               class="hover:text-teal-600">
                                {{$post->title}}
                            </a>
                            <x-public.post-meta :post="$post"></x-public.post-meta>
                        </div>
                    </div>
                    <div class="text-gray-600">
                        {{$post->summary}}

                        <div>
                            <a href="{{$post->link}}"
                               class="text-base font-semibold text-teal-600 hover:text-teal-600">
                                Read full article
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

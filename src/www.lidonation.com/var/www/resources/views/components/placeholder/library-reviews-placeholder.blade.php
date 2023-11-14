<div class="container px-4 py-12 mx-auto sm:px-6 lg:px-8 lg:py-24 animate-pulse">
    <h2 class="pt-0 mt-0 mb-2 text-3xl font-extrabold text-pink-500 xl:text-4xl 2xl:text-3xl">
        {{$snippets->reviews}}
    </h2>
    <p class="mb-8 text-2xl text-gray-500">
        {{$snippets->promisingConsumerFacingProjectsInTheCardanoEcosystem}}
    </p>
    @foreach($groups as $group)
    <div>
        <div class="grid grid-cols-2 gap-8 mb-8 lg:grid-cols-5 lg:grid-rows-4" style="{{$loop->even ? 'direction:rtl;' : ''}}">
            @foreach($group as $post)
            <div style="direction: initial" class="{{$loop->first ? 'lg:row-span-4 col-span-2 lg:col-span-3' : 'lg:row-span-2 lg:col-span-2'}}">
                <div class="flex flex-col justify-start h-full article review">
                    <div class="flex-shrink-0 mb-4">
                        <div>
                            @if($loop->first)
                            <div class="h-110 w-full bg-teal-50 rounded"></div>
                            @else
                            <div class="h-80 w-full bg-teal-50 rounded"></div>
                            @endif
                        </div>
                    </div>
                    <div class="h-4 w-16 bg-teal-50 rounded mt-2"></div>
                    <div class="h-6 w-1/2 bg-teal-50 rounded mt-2"></div>
                    <div class="py-1 mt-2">
                        <span class="hidden md:w-5 md:h-5"></span>
                        <x-public.stars :amount="5" :theme="'text-teal-50'" :size="5" />
                    </div>
                    <div class="flex h-auto flex-col mt-2 gap-1">
                        @foreach(range(1, 5) as $reviewLine)
                        <div class="h-2 w-full bg-teal-50 rounded"></div>
                        @endforeach
                    </div>
                    <div class="mt-4 flex w-full">
                        @if($loop->first)
                        <div class="flex gap-4 w-2/5 pr-8 justify-between">
                            <div class="flex flex-col">
                                <h3 class="mb-4 text-sm capitalize">
                                    All time combined rating
                                </h3>
                                <div class="flex flex-col items-start"></div>
                                <div class="hidden md:w-6 md:h-6"></div>
                                <x-public.stars :amount="5" :theme="'text-teal-50'" :size="6" />
                                <div class="mt-2 rating-average">
                                    <div class="inline-block text-3xl font-semibold xl:text-4xl leading-2">
                                        -.-- / 5
                                    </div>
                                </div>
                                <div>
                                    <span class="inline-block text-sm font-semibold capitalize xl:text-md">
                                        {{ $snippets->averageRating }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-4 all-time-combine-reviews">
                                <h3 class="mb-4 text-sm text-right capitalize">
                                    All time combined reviews
                                </h3>
                                <div class="text-sm text-right">
                                    <div class="rating-count">
                                        <span class="text-4xl font-semibold xl:text-5xl leading-2">
                                            -
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold capitalize">
                                            {{ $snippets->totalReviews }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 w-1/2">
                            @foreach(range(1, 3) as $n)
                            <div class="flex flex-row gap-3 justify-between items-center">
                                <span class="w-20 font-semibold capitalize text-md">5 Star</span>
                                <div class="h-5 w-full bg-teal-50 rounded px-2"></div>
                                <div class="w-8 text-right">
                                    <span class="font-semibold text-md">-%</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    @if($loop->first)
                    <div class="mt-8 all-time-ratings-breakdown ratings-breakdown">
                        <h3 class="mb-4 text-sm capitalize">
                            All time ratings breakdown
                        </h3>
                        <div class="flex flex-row flex-wrap justify-center md:gap-0 categories">
                            @foreach(range(1, 4) as $discussion)
                            <div class="border border-gray-300 -mt-px -ml-px flex-1 border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial] category">
                                <div class="flex flex-col flex-no-wrap flex-no-shrink">
                                    <div class="h-4 w-1/2 bg-teal-50 rounded"></div>
                                    <div class="flex flex-row gap-5 justify-between items-center text-sm flex-no-wrap md:justify-start">
                                        <x-public.stars :amount="5" :theme="'text-teal-50'" :size="4" />
                                        <div class="flex flex-wrap flex-nowrap gap-1 text-xs font-semibold leading-2 sm:text-sm 2x:text-base">
                                            <span>
                                                -
                                            </span>
                                            <span>/</span>
                                            <span>5</span>
                                        </div>
                                        <div class="flex flex-wrap flex-nowrap gap-1 text-sm font-normal leading-2 2x:text-base">
                                            <div class="h-4 w-1/2 bg-teal-50 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="h-4 w-24 bg-teal-50 rounded mt-8"></div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
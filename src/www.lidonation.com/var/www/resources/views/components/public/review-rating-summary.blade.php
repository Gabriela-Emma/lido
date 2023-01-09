@props(['review'])
<div class="mt-6 rating-summary">
    <div class="mt-2 bg-gray-50 bg-opacity-25 rounded-sm">
        <div class="grid grid-cols-7 gap-8 md:gap-16 lg:gap-4 combined-ratings">
            {{-- row 1 --}}
            <div class="col-span-7 md:col-span-4 lg:col-span-3">
                <div class="flex flex-row gap-4 justify-between">
                    <div class="all-time-combined-rating">
                        <h3 class="mb-4 text-sm capitalize">
                            All time combined rating
                        </h3>
                        <div class="">
                            <div class="flex flex-col items-start">
                                <span class="hidden md:w-6 md:h-6"></span>
                                <x-public.stars :amount="round($review->ratings_average)" :size="6" />
                                <div class="mt-2 rating-average">
                                    <span
                                        class="inline-block text-3xl font-semibold xl:text-4xl leading-2">
                                        {{$review->ratings_average_formatted}} / 5
                                    </span>
                                </div>
                                <div>
                                    <span
                                        class="inline-block text-sm font-semibold capitalize xl:text-md">
                                        {{ $snippets->averageRating }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between all-time-combine-reviews">
                        <h3 class="mb-4 text-sm text-right capitalize">
                            All time combined reviews
                        </h3>
                        <div class="text-sm text-right">
                            <div class="rating-count">
                                <span class="text-4xl font-semibold xl:text-5xl leading-2">
                                    {{$review->ratings->count()}}
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
            </div>

            <div class="col-span-7 pt-1 md:col-span-3 lg:col-span-4 chart stacked-bar lg:pl-8">
                <div class="w-full text-sm">
                    @foreach($review->total_ratings_percent_data as $key => $data)
                        <div class="mb-3">
                            @switch($key)
                                @case(1)
                                <div class="flex flex-row gap-3 justify-between items-center">
                                    <div>
                                        <span class="font-semibold capitalize text-md">{{$key}} Star</span>
                                    </div>
                                    <div class="grid flex-1 h-5 bg-gray-100 rounded-sm grid-cols-100">
                                        <div class="h-5 bg-pink-600 rounded-sm"
                                             style="grid-column: span {{$data['percent']}} / span {{$data['percent']}}"></div>
                                    </div>
                                    <div class="w-8 text-right">
                                        <span class="font-semibold text-md">{{$data['percent']}}%</span>
                                    </div>
                                </div>
                                @break

                                @case(2)
                                <div class="flex flex-row gap-3 justify-between items-center">
                                    <div>
                                        <span class="font-semibold capitalize text-md">{{$key}} Star</span>
                                    </div>
                                    <div class="grid flex-1 h-5 bg-gray-100 rounded-sm grid-cols-100">
                                        <div class="h-5 bg-pink-400 rounded-sm"
                                             style="grid-column: span {{$data['percent']}} / span {{$data['percent']}}"></div>
                                    </div>
                                    <div class="w-8 text-right">
                                        <span class="font-semibold text-md">{{$data['percent']}}%</span>
                                    </div>
                                </div>
                                @break

                                @case(3)
                                <div class="flex flex-row gap-3 justify-between items-center">
                                    <div>
                                        <span class="font-semibold capitalize text-md">{{$key}} Star</span>
                                    </div>
                                    <div class="grid flex-1 h-5 bg-gray-100 rounded-sm grid-cols-100">
                                        <div class="h-5 bg-yellow-600 rounded-sm"
                                             style="grid-column: span {{$data['percent']}} / span {{$data['percent']}}"></div>
                                    </div>
                                    <div class="w-8 text-right">
                                        <span class="font-semibold text-md">{{$data['percent']}}%</span>
                                    </div>
                                </div>
                                @break

                                @case(4)
                                <div class="flex flex-row gap-3 justify-between items-center">
                                    <div>
                                        <span class="font-semibold capitalize text-md">{{$key}} Star</span>
                                    </div>
                                    <div class="grid flex-1 h-5 bg-gray-100 rounded-sm grid-cols-100">
                                        <div class="h-5 rounded-sm bg-accent-600"
                                             style="grid-column: span {{$data['percent']}} / span {{$data['percent']}}"></div>
                                    </div>
                                    <div class="w-8 text-right">
                                        <span class="font-semibold text-md">{{$data['percent']}}%</span>
                                    </div>
                                </div>
                                @break

                                @case(5)
                                <div class="flex flex-row gap-3 justify-between items-center">
                                    <div>
                                        <span class="font-semibold capitalize text-md">{{$key}} Star</span>
                                    </div>
                                    <div class="grid flex-1 h-5 bg-gray-100 rounded-sm grid-cols-100">
                                        <div class="h-5 rounded-sm bg-accent-300"
                                             style="grid-column: span {{$data['percent']}} / span {{$data['percent']}}"></div>
                                    </div>
                                    <div class="w-8 text-right">
                                        <span class="font-semibold text-md">{{$data['percent']}}%</span>
                                    </div>
                                </div>
                                @break
                            @endswitch
                        </div>
{{--                        <div class=""--}}
{{--                             style="grid-column: span {{$data['percent']}} / span {{$data['percent']}}">--}}
{{--                            @switch($key)--}}
{{--                                @case(1)--}}
{{--                                <div class="flex flex-row items-center p-2 w-full h-full bg-pink-600">--}}
{{--                                    <span class="text-xs font-semibold">{{$data['percent']}}%</span>--}}
{{--                                </div>--}}
{{--                                @break--}}

{{--                                @case(2)--}}
{{--                                <div class="flex flex-row items-center p-2 w-full h-full bg-pink-400">--}}
{{--                                    <span class="text-xs font-semibold">{{$data['percent']}}%</span>--}}
{{--                                </div>--}}
{{--                                @break--}}

{{--                                @case(3)--}}
{{--                                <div class="flex flex-row items-center p-2 w-full h-full bg-yellow-600">--}}
{{--                                    <span class="text-xs font-semibold">{{$data['percent']}}%</span>--}}
{{--                                </div>--}}
{{--                                @break--}}

{{--                                @case(4)--}}
{{--                                <div class="flex flex-row items-center p-2 w-full h-full bg-accent-600">--}}
{{--                                    <span class="text-xs font-semibold">--}}
{{--                                        {{$data['percent']}}%--}}
{{--                                    </span>--}}
{{--                                </div>--}}
{{--                                @break--}}

{{--                                @case(5)--}}
{{--                                <div class="flex flex-row items-center p-2 w-full h-full bg-accent-300">--}}
{{--                                    <span class="text-xs font-semibold">--}}
{{--                                        {{$data['percent']}}%--}}
{{--                                    </span>--}}
{{--                                </div>--}}
{{--                                @break--}}
{{--                                @default--}}
{{--                                <div class="w-full h-full bg-gray-50">--}}
{{--                                    <span class="align-content-center">{{$data['percent']}}%</span>--}}
{{--                                </div>--}}
{{--                            @endswitch--}}
{{--                        </div>--}}
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-8 all-time-ratings-breakdown ratings-breakdown">
            <h3 class="mb-4 text-sm capitalize">
                All time ratings breakdown
            </h3>
            <div class="flex flex-row flex-wrap justify-center md:gap-0 categories">
                @foreach($review->discussions as $discussion)
                    <div
                        class="border border-gray-300 -mt-px -ml-px flex-1 border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial] category">
                        <div class="flex flex-col flex-no-wrap flex-no-shrink">
                            <h3 class="text-xl">{{$discussion->title}}</h3>
                            <div
                                class="flex flex-row gap-5 justify-between items-center text-sm flex-no-wrap md:justify-start">
                                <x-public.stars :amount="$discussion->rating" :size="4" />
                                <div
                                    class="flex flex-wrap flex-nowrap gap-1 text-xs font-semibold leading-2 sm:text-sm 2x:text-base">
                                    <span>
                                        {{$discussion->rating}}
                                    </span>
                                    <span>/</span>
                                    <span>5</span>
                                </div>
                                <div
                                    class="flex flex-wrap flex-nowrap gap-1 text-sm font-normal leading-2 2x:text-base">
                                    <span>{{$discussion->ratings_count}}</span>
                                    <span>
                                        {{ $snippets->reviews }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

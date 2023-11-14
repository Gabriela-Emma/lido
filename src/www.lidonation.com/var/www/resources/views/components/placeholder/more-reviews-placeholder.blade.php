@props([
    'count' => 1,
])
    @foreach(range(1, $count) as $review)
        <div class="flex flex-col shrink-0 snap-center w-full @if($review > 1 ) mt-4 @endif">
            <div class="flex shrink-0 snap-start flex-col gap-2 items-start justify-center podcast-inner h-full">
                <div class="relative w-full h-full gap-4">
                    <div class="h-110 bg-teal-50 rounded"></div>
                    <div class="h-4 w-16 bg-teal-50 rounded mt-2"></div>
                    <div class="h-6 w-1/2 bg-teal-50 rounded mt-2"></div>
                    <div class="py-1 mt-2">
                        <span class="hidden md:w-5 md:h-5"></span>
                        <x-public.stars :amount="5" :theme="'text-teal-50'" :size="5"/>
                    </div>
                    <div class="flex h-auto flex-col mt-2 gap-1">
                        @foreach(range(1, 4) as $reviewLine)
                            <div class="h-2 w-full bg-teal-50 rounded"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
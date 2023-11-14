@props([
    'count' => 1,
])

<div class="flex flex-col gap-4 w-full">
@foreach(range(1, $count) as $post)
    <div class="flex flex-col w-full pt-4">
        <div class="flex flex-row justify-center gap-4">
            <div class="flex-shrink-0 block w-40 sm:w-64">
                <div class="h-64 w-full bg-teal-50 object-cover rounded-tl-[14rem] rounded-tr-[12rem] rounded-br-[11rem] rounded-bl-[0.5rem]">
                    <div class="mb-4 flex-shrink-0 hero-wrapper w-full h-full"></div>
                </div>
            </div>
            
            <div class="flex flex-col w-full gap-4 pt-4">
                    <div class="flex h-auto flex-row gap-4">
                        @foreach (range(1, 4) as $n)
                            <span class="h-4 w-16 bg-teal-50 rounded"></span>
                        @endforeach
                    </div>
                    <div class="h-8 w-3/4 bg-teal-50 rounded"></div>
                    <div class="flex h-12 flex-row gap-4">
                        @foreach (range(1, 3) as $n)
                            <span class="h-4 w-24 bg-teal-50 rounded"></span>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
@endforeach
</div>

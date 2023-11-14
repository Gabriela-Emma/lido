<div class="gap-6 md:grid md:grid-cols-2 2xl:grid-cols-5 animate-pulse lido-origin">
    <div class="flex flex-col gap-4  rounded-sm w-full p-8 sm:gap-8 2xl:col-span-3">
        <div class="h-12 pr-4 bg-primary-50 rounded w-2/3"></div>
        <div class="w-full flex flex-col gap-2 sm:gap-4">
            @foreach(range(1, 6) as $line)
                <div class="h-4 bg-primary-50 rounded w-full"></div>
            @endforeach
        </div>
        <div class="h-8 pr-4 bg-primary-50 rounded w-2/3"></div>
    </div>
    <div class="rounded-sm w-full p-2 md:p-8 2xl:col-span-2 bg-primary-40">
        <div class="flex flex-row flex-wrap justify-around">
            @foreach(range(1, 6) as $metric)
                <div class="p-2">
                    <div class="flex justify-center rounded-full w-32 h-32 bg-primary-50"></div>
                </div>
            @endforeach
        </div>
    </div>
</div>

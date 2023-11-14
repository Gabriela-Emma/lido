<div
    class="rounded-sm podcast-wrapper">
    <div
        class="flex shrink-0 snap-start flex-col gap-2 items-start justify-center podcast-inner"
        role="option">
        <div class="relative">
            <img class="w-full rounded-sm shadow-sm shadow-inner"
                 src="{{$post->preview_link}}"
                 alt="placeholder image">

            <div
                class="absolute left-0 bottom-0 flex gap-2 items-center text-yellow-500 bg-gradient-to-t from-slate-800 h-auto w-full p-2">
                <div class="flex w-full">
                    <div class="w-3/4">
                        <h2 class="text-xl xl:text-2xl 2xl:text-4xl font-medium text-white">
                            {{$post->name}}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

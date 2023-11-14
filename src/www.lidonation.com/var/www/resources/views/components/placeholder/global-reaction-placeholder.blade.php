<div>
    <ul class="flex flex-row flex-wrap gap-4 justify-center">
        @foreach (range(1, 6) as $n)
            <div
                class="border-0 flex flex-row gap-2 border-slate-600 hover:border-green-500 p-2 rounded-sm text-lg cursor-pointer w-[4rem] h-[3.25rem] animate-pulse bg-primary-50">
            </div>
        @endforeach
    </ul>
</div>

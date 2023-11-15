@props(['title', 'subTitle'])

<header class="bg-white">
    <div class="flex flex-wrap items-center justify-between gap-4 py-6 container">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-2xl font-semibold lg:text-3xl 2xl:text-4xl text-teal-600">
                    {{ $title }}
                </h1>
                <div class="flex flex-row">
                    <p class="text-slate-600 text-sm">
                        {{ $subTitle }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</header>

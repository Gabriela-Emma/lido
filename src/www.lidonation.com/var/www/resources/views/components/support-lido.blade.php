@props([
   'heading-leading',
   'heading-span'
])
<section id="support-library" class="bg-primary-20 py-16 sm:py-20 relative">
    <div class="container">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-2xl font-semibold leading-8 text-slate-800 tracking-tight text-slate-800 lg:text-4xl xl:text-5xl 2xl:text-6xl 2xl:max-w-7xl">
                {{ $headingLeading}} <span class="text-teal-500">{{ $headingSpan }}</span>
            </h2>
            <p class="mt-5 text-lg font-semibold leading-6 text-slate-400 max-w-sm text-center mx-auto">
                You can support the work we do by delegating to the LIDO pool, pickup a ware in our bazaar,
                or sponsor a podcast episode.
            </p>
            <div class="flex gap-2 justify-center mt-5">
                <a type="button" href="{{localizeRoute('delegators')}}"
                   class="inline-flex items-center rounded-sm border border-transparent bg-eggplant-500 px-4 py-2 text-base font-medium text-slate-50 shadow-sm hover:bg-eggplant-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    Delegate to LIDO
                </a>
                <a type="button" href="{{localizeRoute('bazaar')}}"
                   class="inline-flex items-center rounded-sm border border-transparent bg-green-500 px-4 py-2 text-base font-medium text-slate-800 shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Shop
                </a>
                <a type="button" href="{{localizeRoute('lido-minute-nft')}}"
                   class="inline-flex items-center rounded-sm border border-transparent bg-yellow-500 px-4 py-2 text-base font-medium text-slate-800 shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Sponsor a podcast episode
                </a>
            </div>
        </div>

        <div class="mt-16 shadow-xs border-4 border-slate-800 rounded-sm">
            <x-lido.origin theme="green"/>
        </div>
    </div>
</section>
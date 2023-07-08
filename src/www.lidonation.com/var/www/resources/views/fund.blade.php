<x-public-layout class="fund" :metaTitle="$fund->label">
    @push('openGraph')
        <meta property="og:type" content="article"/>
        <meta property="og:title" content="{{$fund->label}}"/>
        <meta property="og:description" content="{{$fund->excerpt}}"/>
        <meta property="og:url" content="{{$fund->url}}"/>
        <meta property="og:image" content="{{$fund->hero_url}}"/>
        <meta property="og:image:width" content="2048"/>
        <meta property="og:image:height" content="2048"/>
        <meta property="article:publisher" content="{{config('app.name')}}"/>
        <meta property="article:published_time" content="{{$fund->launched_at}}"/>
        <meta property="twitter:card" content="summary_large_image"/>
        <meta property="twitter:title" content="{{$fund->label}}"/>
        <meta property="twitter:description" content="{{$fund->excerpt}}"/>
        <meta property="twitter:image" content="{{$fund->hero_url}}"/>
        <meta property="twitter:url" content="{{$fund->url}}"/>
        <meta property="twitter:site" content="@lidonation"/>
    @endpush

    @livewire('catalyst.catalyst-sub-menu-component')

    <header class="text-white bg-teal-600">
        <div class="container">
            <section class="relative z-0 py-10 overflow-visible">
                <h1 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate light'>
                    <img class="w-10 h-10 rounded-sm lg:w-16 lg:h-16"
                         src="{{$fund->hero_url}}"
                         alt="{{$fund->label}} gravatar"/>

                    <span class="font-semibold">
                        {{$fund->label}}
                    </span>
                </h1>

                <div class="my-4 summary">
                    <div class="max-w-4xl font-semibold">
                        Charts and Reports coming soon
                    </div>
                </div>
            </section>
        </div>
    </header>

    <section
        class="relative py-10 overflow-visible bg-white bg-left-bottom bg-repeat-y bg-contain bg-opacity-90 bg-blend-color-burn lg:py-20 bg-pool-bw-light">
        <div class="container">
            <h2 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate dark'>
                {{$fund->label}} <span class="text-teal-600">Challenges</span>
                <span class="text-gray-500 2xl:text-4xl">({{$challenges->count()}})</span>
            </h2>

            <div class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-6">
                @foreach($challenges as $challenge)
                    <x-catalyst.funds.drip :fund="$challenge" />
                @endforeach
            </div>

            <div class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-6">
                {{ $challenges->onEachSide(5)->links() }}
            </div>
        </div>
    </section>
</x-public-layout>

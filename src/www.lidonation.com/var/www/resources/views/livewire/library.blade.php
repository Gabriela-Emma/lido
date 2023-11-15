<div>
    <section class="relative py-8 bg-white md:py-16">
        <div class="container flex flex-row items-center justify-between">
            <div class="flex flex-col gap-1">
                <h1 class="text-4xl font-semibold leading-8 tracking-tight text-slate-800 lg:text-5xl xl:text-6xl 2xl:text-7xl md:pr-8 xl:pr-20 2xl:max-w-7xl">
                    Lido Nation <span class="text-teal-500">Library</span>
                </h1>
                <p class="xl:text-2xl 2xl:text-3xl">
                    Blockchain Education in Plain <br/>
                    <span class="font-semibold text-yellow-500">English</span>,
                    <span class="font-semibold text-slate-800">Kiswahili</span>, &
                    <span class="font-semibold text-green-500">Español</span>.
                </p>

                <div>
                    <x-global.mailchimp-form layout="row"/>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="">
                    <span class="text-2xl lg:text-4xl xl:text-7xl 2xl:text-10xl text-slate-200 font-display">
                        <livewire:components.library-post-count lazy="on-load" />
                    </span>
                </div>
            </div>
        </div>
    </section>

    <livewire:components.new-to-library lazy="on-load" />

    @if($categories && !empty($categories))
        @foreach(collect($categories)->take(2) as $cat)
            @if($cat->models && $cat->models->isNotEmpty())
                <section class="relative py-16 bg-white border-t border-slate-300">
                    <div class="container">
                        <livewire:components.taxonomy-component :taxonomy="$cat" :per-page="4" lazy="on-scroll" />
                    </div>
                </section>
            @endif
        @endforeach
    @endif

    <section class="relative py-16 bg-primary-10">
        <livewire:library.reviews-component lazy="on-scroll"/>
    </section>

    <x-global.tags :tags="$tags" :bgColor="'bg-eggplant-600'"/>

    <livewire:components.lido-minute-list-component />

    <section class="relative py-16">
        <div class="container">
            <livewire:components.support-lido-component theme="teal" lazy="on-scroll" title="Support the Library" />
        </div>
    </section>

    @if(!empty($categories))
        @foreach(collect($categories)->skip(2)->take(2) as $cat)
            @if($cat->models && $cat->models->isNotEmpty())
                <section class="relative py-16 bg-primary-10 border-y">
                    <div class="container">
                        <livewire:components.taxonomy-component :taxonomy="$cat" :per-page="4" lazy="on-scroll" :theme="\App\Enums\ComponentThemesEnum::plain" />
                    </div>
                </section>
            @endif
        @endforeach
    @endif

    <section id="new-to-cardano" class="relative bg-white">
        <livewire:components.new-to-cardano title="New To Cardano"/>
    </section>

    @if(!empty($categories))
        @foreach(collect($categories)->skip(4)->take(2) as $cat)
            @if($cat->models && $cat->models->isNotEmpty())
                <section class="relative py-16 bg-primary-10 border-y">
                    <div class="container">
                        <livewire:components.taxonomy-component :taxonomy="$cat" :per-page="4" lazy="on-scroll" :theme="\App\Enums\ComponentThemesEnum::column" />
                    </div>
                </section>
            @endif
        @endforeach
    @endif
</div>

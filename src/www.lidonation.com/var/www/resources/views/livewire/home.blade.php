<div>
    <section class="relative pt-16 pb-8 mb-6 bg-white">
        <div class="container">
            <x-markdown>{{$snippets->homeSnippetOne}}</x-markdown>
            <div class="max-w-6xl mt-2">
                <x-markdown>{{$snippets->homeSnippetTwo}}</x-markdown>
            </div>
        </div>
    </section>

    <section class="relative py-16 bg-primary-10">
        <livewire:components.new-to-library lazy="on-load" />
    </section>

    <section class="relative py-10 mb-8 bg-white">
        <div class="container">
            <x-global.getting-started />
        </div>
    </section>

    <section class="relative py-10 mb-8 bg-white">
        <div class="container gap-6 lg:grid lg:grid-cols-3 lg:gap-10 xl:gap-16">
            <div class="lg:col-span-2">
                <livewire:components.blockchain-headlines-component :limit="6" lazy="on-scroll" />
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <livewire:components.reviews :limit="2" lazy="on-scroll" />
                </div>
            </div>
        </div>
    </section>

</div>

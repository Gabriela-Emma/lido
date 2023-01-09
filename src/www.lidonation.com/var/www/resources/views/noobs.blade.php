<x-public-layout class="team" title="Blockchain Noobs">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class='font-thin block'>{{__('Blockchain') }}</span>
            <span class='font-black'>{{__('Noobs') }}.</span>
        </x-slot>

        <p>
            So you recently bought your first ADA, or bought it back in 2017 and your eclectic friend has been singing
            songs in your ear about cardano recently.
        </p>

        <p>
            But but but, you still don't quite understand much of it. Resources on this page is to help give you a 6th
            grade understanding of blockchain technology and how cardano uses the blockchain to literally change the
            world.
        </p>
    </x-public.page-header>

    <section class="py-32 bg-pool-bw-light bg-cover bg-left-top bg-opacity-50 bg-white"
             style="background-blend-mode: lighten" aria-labelledby="quick-links-title">
        <div class="container">
            <div class="bg-white py-16 px-4 sm:px-6 lg:px-8">
                <div class="relative mx-auto divide-y-2 divide-gray-300">
                    <div class="flex justify-center">
                        <div class="mx-auto">
                            @foreach($noobPosts as $post)
                                <div class="relative flex flex-row w-full">
                                    <x-public.noob-item
                                        :index="$loop->iteration"
                                        :post="$post"
                                        :orientation="$loop->odd ? 'left' : 'right'"></x-public.noob-item>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>

<x-public-layout class="team" title="Blockchain Glossary">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class='font-thin block'>{{__('Blockchain') }}</span>
            <span class='font-black'>{{__('Glossary') }}.</span>
        </x-slot>

        <p>
            Non-techie-friendly definitions of popular blockchain phrases and words to help you speak the speak, or
            at least know what the kids are talking about. Super popular phrases based on google search ranking are larger in list.
        </p>
    </x-public.page-header>

    <section class="relative md:p-8 bg-teal-600 box-border">
        <dl class="grid glossary grid-cols-2 md:grid-cols-10 lg:grid-cols-12 auto-rows-auto gap-1 p-4 text-center text-teal-50" x-data="glossary()">
            @foreach($definitions as $definition)
                <div x-on:click="show({{$definition->id}})"
                     :class="{
                    'col-span-3 row-span-3': isShowing({{$definition->id}}) && $refs.dd.innerText.length > 20,
                    'col-span-3 row-span-4': isShowing({{$definition->id}}) && $refs.dd.innerText.length > 200,
                    'col-span-4 row-span-4': isShowing({{$definition->id}}) && $refs.dd.innerText.length > 300,
                    'col-span-4 row-span-5': isShowing({{$definition->id}}) && $refs.dd.innerText.length > 400,
                    'col-span-5 row-span-5': isShowing({{$definition->id}}) && $refs.dd.innerText.length > 520
                 }"
                     class="shape morph-2 text-gray-200 inline-flex flex-col justify-center bg-gradient-to-r from-primary-500 to-primary-700 hover:from-accent-600 hover:to-accent-800 cursor-pointer">
                    <dt class="p-4 text-sm md:text-base lg:text-lg inline-block font-extrabold">{{$definition->name}}</dt>
                    <dd x-ref="dd"
                        :aria-expanded="isShowing({{$definition->id}}) ? 'true' : 'false'"
                        :class="{ 'hidden': !isShowing({{$definition->id}}) }"
                        class="p-0 overflow-hidden transition-all duration-150 ease-in-out text-left">
                    <span class="inline-block p-16 pt-0">{{$definition->content}}</span>
                    </dd>
                </div>
            @endforeach
        </dl>
    </section>

    <div class="relative">
    <x-public.join-lido-pool></x-public.join-lido-pool>
    </div>

</x-public-layout>

<x-public-layout class="team" title="Connect with the community">
    <x-public.page-header :size="'md'" >
        <x-slot name="title">
            <span class='text-teal-600 block'>{{__('Connect') }}</span>
            <span class='font-thin'>{{__('with the Community') }}.</span>
        </x-slot>
        <p>
            The LIDO Nation community is a diverse, global community unified by the prospect of financial, identity,
            and governing systems that work for everyone.
            To best cater to our diverse community we offer a range of online and offline venues to connect and share
            ideas.
        </p>

        <p>
            Find a cohort, a way you prefer to relate, and jump in!
        </p>

{{--        <p>--}}
{{--            We are two polyglot developers and kubernetes service providers with ears on the crypto spaces since 2016;--}}
{{--            bringing you a 2% margin community pool for everyone.--}}
{{--        </p>--}}
{{--        <p>--}}
{{--            We also manage over a dozen kubernetes environments so LIDOLOVELACE will always benefit--}}
{{--            from up to date expertise in security, performance and efficiency optimizations.--}}
{{--        </p>--}}

    </x-public.page-header>

    <div class="bg-lido-boy bg-cover bg-center relative z-20">
        <x-public.mailgun></x-public.mailgun>
    </div>

    <section class="bg-gray-100">
        <div class="container mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <x-public.contact-lido></x-public.contact-lido>
        </div>
    </section>

    <x-support-lido heading-leading='Support the' heading-span='Library'/>

</x-public-layout>

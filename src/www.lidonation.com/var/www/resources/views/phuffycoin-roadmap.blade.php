<x-public-layout class="phuffycoin phuffycoin-roadmap">
    {{--    <x-public.page-header :size="'md'">--}}
    {{--        <x-slot name="title">--}}
    {{--            <span class="block flex z-20 flex-col gap-3 sm:flex-row">--}}
    {{--                <span class='z-20 font-black text-teal-600'>{{__('PHUFFY') }}</span>--}}
    {{--                <span class='z-20 font-light'>{{__('Coin') }}</span>--}}
    {{--            </span>--}}
    {{--        </x-slot>--}}
    {{--    </x-public.page-header>--}}

    <section class="relative text-white bg-white section-1 lg:text-xl">
        <div class="container relative py-16 pt-24">
            <h1 class="z-10 text-6xl"><b>PHUFFY</b> Coin</h1>
            <div class="flex z-10 flex-col gap-6 max-w-3xl">
                <div>
                    <p>
                        <b>Together we are creating the future. What do you want it to look like?</b>
                    </p>
                </div>

                <div>
                    <p>
                        <b>Phuffy Coin is a perk for our pool delegators, allowing them to direct our pool's charitable
                            giving.</b>
                    </p>
                </div>

                <div>
                    <p>
                        Eventually, Phuffy coin will become a tool that the whole Cardano community can use to fundraise
                        and crowdsource for causes or as a decentralize to have a communities prioritize and direct
                        funding.
                        The structure of Phuffy coin encourages cooperation, teamwork, and generosity.
                    </p>
                </div>
                <div>
                    <p>
                        This page introduces the Phuffy coin "roadmap." The eras of our journey are named for the layers
                        of Earth's atmosphere. We start with a charitable voting token, and end among the stars!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Troposphere -->
    <section class="relative text-white bg-white lg:text-xl">
        <div class="section-2">
            <div class="container py-16">
                <div class="flex">
                    <div class="w-[13rem] h-[13rem] relative">
                        <div
                            class="w-[16rem] h-[16rem] rounded-full absolute left-[-11rem] bg-accent-900 bg-opacity-75"></div>
                        <div class="w-[18rem] h-[18rem] absolute left-[-3rem] top-[-2rem]">
                            @include('svg.bird-flock')
                        </div>
                    </div>
                    <div class="flex z-10 flex-col gap-6 max-w-3xl">
                        <h2 class="text-5xl">Troposphere</h2>
                        <div>
                            <p>
                                <b>In the "troposphere" era, LIDO pool delegators can register to receive Phuffy coin
                                    and vote for charitable causes.</b>
                            </p>
                        </div>
                        <div class="pl-6">
                            <p class="pb-0 mb-0">
                                Delegators receive Phuffy coin automatically, every time rewards are distributed.
                                Staking rewards are governed by the Cardano network,
                                but Phuffy coin is governed by our pool, and ultimately by you - our delegator
                                community.
                                Phuffy coin distribution seeks a balance between these values:
                            </p>
                            <ul class="mt-0 ml-6 list-disc list-outside">
                                <li>Stake: Higher stakes are scored higher, and get more voting power.</li>
                                <li>Loyalty: Over time, even modest stakes earn influential giving power.</li>
                            </ul>
                        </div>
                        <div class="pl-6">
                            <p>
                                Learn more about the Phuffy coin scoring and distribution model here.
                                In this era, winning causes will be decided on a quarterly basis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stratosphere -->
    <section class="relative bg-primary-900 lg:text-xl">
        <div class="relative section-3">
            {{--            <div class="absolute top-0 left-0 w-1/4 h-full bg-opacity-50 bg-gradient-to-r to-primary-400 via-primary-600 from-primary-800 bg-teal-800"></div>--}}
            {{--            <div class="absolute top-0 right-0 w-1/4 h-full bg-opacity-50 bg-gradient-to-r to-primary-400 via-primary-600 from-primary-800 bg-teal-800"></div>--}}
            <div class="container py-16">
                <div class="flex">
                    <div class="w-[13rem] h-[13rem] relative z-0">
                        <div
                            class="w-[16rem] h-[16rem] rounded-full absolute left-[-11rem] bg-accent-900 bg-opacity-75"></div>
                        <div class="w-[18rem] h-[18rem] absolute left-[-6rem] top-[-1rem] text-gray-300 opacity-80">
                            @include('svg.plane')
                        </div>
                    </div>

                    <div class="flex z-10 flex-col gap-6 max-w-3xl text-white">
                        <h2 class="pb-0 mb-0 text-5xl">Stratosphere</h2>
                        <div>
                            <p>
                                <b>
                                    In the "stratosphere" era,
                                    registered delegators will receive exclusive Phuffy coin NFTs for participating.
                                </b>
                            </p>
                        </div>
                        <div class="pl-6">
                            <p class="pb-0 mb-0">
                                Exclusive Phuffy coin NFTs are awarded to founding delegators.
                                Votes for winning causes and ongoing participation earn additional NFTs -
                                a growing "trophy case" for our delegators, who are leading our charitable giving
                                (at no
                                cost to themselves)!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mesosphere -->
    <section class="overflow-visible relative text-white lg:text-xl">
        <div class="section-4">
            <div class="container py-16">
                <div class="flex overflow-visible relative">
                    <div class="w-[13rem] h-[13rem] relative z-10">
                        <div
                            class="w-[16rem] h-[16rem] rounded-full absolute left-[-11rem] bg-accent-900 bg-opacity-75"></div>
                        <div
                            class="w-[12rem] h-[12rem] absolute left-[-2rem] top-[-6rem] z-10 text-gray-300 opacity-80">
                            @include('svg.rocket')
                        </div>
                    </div>
                    <div class="flex z-10 flex-col gap-6 max-w-3xl">
                        <h2 class="text-5xl">Mesosphere</h2>
                        <div>
                            <p>
                                <b>
                                    In the "mesosphere" era, delegators can nominate charitable causes of their
                                    choosing!
                                </b>
                            </p>
                        </div>
                        <div class="pl-6">
                            <p class="pb-0 mb-0">
                                In order to rise to the "voting" ballot, new nominations must receive "seconds" -
                                this encourages cooperation and communication. To support these new participation
                                layers,
                                this era will introduce new communication channels for users.
                                The donation cycle will increase from quarterly to monthly.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Thermosphere -->
    <section class="relative text-white lg:text-xl">
        <div class="section-5">
            <div class="container py-16">
                <div class="flex">
                    <div class="w-[13rem] h-[13rem] relative">
                        <div
                            class="w-[16rem] h-[16rem] rounded-full absolute left-[-11rem] bg-accent-900 bg-opacity-75"></div>
                        <div class="w-[12rem] h-[12rem] absolute left-[-3rem] top-[-2rem] text-gray-300 opacity-80">
                            @include('svg.satelite-in-orbit')
                        </div>
                    </div>
                    <div class="flex z-10 flex-col gap-6 max-w-3xl">
                        <h2 class="text-5xl">Thermosphere</h2>
                        <div>
                            <p>
                                <b>
                                    In the "thermosphere" era, the Cardano community will be invited to use Phuffy coin
                                    to nominate and vote for causes along with our Pool!
                                </b>
                            </p>
                        </div>
                        <div class="pl-6">
                            <p class="pb-0 mb-0">
                                Phuffy coin will continue to be a FREE perk for LIDO delegators,
                                but others will be invited to use Phuffy coin to nominate, vote, and fundraise for
                                causes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Exosphere -->
    <section class="relative text-white lg:text-xl">
        <div class="section-6">
            <div class="container py-16">
                <div class="flex relative">
                    <div class="w-[13rem] h-[13rem] relative">
                        <div
                            class="w-[16rem] h-[16rem] rounded-full absolute left-[-11rem] bg-accent-900 bg-opacity-75"></div>
                        <div class="w-[18rem] h-[18rem] absolute left-[-6rem] top-[-9rem]">
                            <img src="{{asset('img/sparkles.png')}}"/>
                        </div>
                    </div>
                    <div class="flex z-10 flex-col gap-6 max-w-3xl">
                        <h2 class="text-5xl">Exosphere</h2>
                        <div>
                            <p>
                                <b>
                                    In the "exosphere" era, the stars are the limit!
                                </b>
                            </p>
                        </div>
                        <div class="pl-6">
                            <p class="pb-0 mb-0">
                                Someday, the rules that govern Phuffy coin will be decided and updated by our delegators
                                and the Phuffy coin user community in a DAO. The impact for good that we can make
                                together is expanding,
                                along with the galaxies, moon rocks, and star dust around us.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>

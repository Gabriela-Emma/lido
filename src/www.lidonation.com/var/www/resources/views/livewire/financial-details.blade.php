<div class="financial-details" title="LIDO Financial details">

    <div class="p-16 container">
        <div class="flex flex-row gap-1">
            <span class='font-light text-[60px]'>{{__('Financial') }}</span>
            <span class='font-black text-teal-600 text-[60px]'>{{__('Details') }}</span>
        </div>

        <div class=" mt-8 w-[50%]">
            <p>
                Lido Nation is a node in the Cardano blockchain network.
                Cardano supports decentralized financial, identity and governance tools.
                <strong>Together we are building a future that works for everyone.</strong>
            </p>

            <p>
                Running a network node is a job, so we get paid for participating in a project we believe in.
                <strong>We also want to create more good in the world with you, our delegators.</strong>
                This page describes how we do it, together.
            </p>
        </div>
    </div>

    <section class="bg-teal-600 text-white py-8 z-10 relative">
        <div class="container">
            <div class="flex flex-col-reverse md:flex-row gap-16 items-center 2xl:pr-80">
                <div class="w-1/4 x-auto md:w-[8rem]">
                    @include('svg.gears')
                </div>
                <div>
                    <p>When Lido Nation mints a block on the network, our pool receives a sum of ADA.</p>
                    <p>
                        <strong>Reward amounts are calculated and sent to pool operators and delegators
                            AUTOMAGICALLY.</strong>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-accent-200 py-8 z-10 relative">
        <div class="container">
            <div class="flex flex-col-reverse md:flex-row gap-16 items-center 2xl:pr-80">
                <div>
                    <p>
                        Cardano rules dictate that a static fee of 340₳ is sent to the pool operator if the pool makes
                        at least
                        one block during the course of the five-day epoch.
                    </p>
                    <p>
                        <strong>At Lido Nation, this income covers our fixed costs:</strong>
                        server, website, email platform, and similar business-related expenses.
                    </p>
                </div>
                <div class="w-1/4 x-auto md:w-[20rem] text-teal-700">
                    @include('svg.340-ada')
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-8 z-10 relative">
        <div class="container">
            <div class="flex flex-col-reverse md:flex-row gap-16 items-center 2xl:pr-80">
                <div class="w-1/4 x-auto md:w-[50rem] text-teal-700">
                    <img width="320" height="320" src="{{asset('img/margin-pie.png')}}"
                         alt="SPO Reward Margin Piechart"/>
                </div>
                <div>
                    <p>
                        From the rest of the rewards, <strong>96% goes directly to our delegators</strong>.
                    </p>
                    <p>
                        The remaining 4%* is called the "pool margin". This allows us to have some fun together,
                        participate more fully in the Cardano ecosystem, <strong>and give generously to causes chosen by
                            you</strong>.
                    </p>
                    <p class="text-sm">
                        There is some confusion about how margin works and how much it impacts delegator rewards;
                        some delegators choose a pool simply by looking for the lowest possible margin.
                        This is probably not worthwhile; there are many factors that affect delegator rewards,
                        and the impact of a percent or two of margin is negligible. For example, if you stake ₳1K,
                        you may make ₳58.8 in rewards in a year from a pool that has a 2% margin. All other factors
                        being equal,
                        you would make ₳57.6 in a year in a pool charging 4%, like LIDO! For individual delegators the
                        difference is very small, but as a group, it makes big difference in what we can accomplish!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-teal-600 text-white py-8 z-10 relative">
        <div class="container">
            <div class="flex flex-col-reverse md:flex-row gap-16 items-center 2xl:pr-80">
                <div>
{{--                    <p>--}}
{{--                        From our pool margin, <strong>HALF is dedicated to charitable giving.</strong>--}}
{{--                        Visit the <a class="text-accent-400 hover:text-white"--}}
{{--                                     href="{{localizeRoute('purpose-driven-pool')}}">PURPOSE</a> page to learn more,--}}
{{--                        get registered, and vote!--}}
{{--                    </p>--}}
                    <p>
                        <strong>
                            One quarter of our margin supports content and enhancements that enrich the Lido Nation
                            delegator experience.
                        </strong>
                        This may include producing new content, expanding available translations, and other projects
                        that we dream up together!
                    </p>
                    <p>
                        The remaining quarter is what makes this a "real job" for our pool operators and staff.
                        <strong>Thanks for being a part of our vision to build a company that can do well, and do
                            good.</strong>
                    </p>
                </div>
                <div class="w-1/4 x-auto md:w-[40rem] text-teal-700">
                    <img width="280" height="280" src="{{asset('img/lido-budget-breakdown.png')}}"
                         alt="SPO Reward Margin Pie chart"/>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container">
            <livewire:components.support-lido-component theme="teal" lazy="on-scroll"/>
        </div>
    </section>
</div>

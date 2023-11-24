<template>
    <Head title="Project Catalyst Delegated Representatives (DRreps)" />

    <section class="bg-white">
        <header class="py-16">
            <div class="container">
                <h1
                    class="text-3xl font-light leading-8 tracking-tight text-slate-800 sm:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl pr-8 2xl:max-w-7xl"
                >
                    <span class="font-bold text-yellow-500 inline-block mr-0.5">DReps.</span>
                    <span
                    > Delegate Representatives in Project Catalyst.</span
                    >
                </h1>
            </div>
        </header>

        <div class="bg-white">
            <div class="space-y-10">
                <section class="bg-primary-20 py-24">
                    <div class="container">
                        <div class="xl:px-36">
                            <p
                                class="text-2xl font-bold text-teal-600 hover:text-teal-800"
                            >
                                Project Catalyst's Continued Growth and the Need for
                                Delegation
                            </p>

                            <p
                                class="text-xl font-light leading-relaxed tracking-wide"
                            >
                                The Cardano community's Project Catalyst fund has
                                experienced remarkable growth since its inception,
                                with Fund8 receiving nearly 1,000 proposals. This
                                expansion, while positive, poses a challenge as it
                                increases the community's responsibility to review
                                and vote on an ever-growing number of proposals. To
                                address this challenge and ensure the sustainability
                                of Project Catalyst, a new system of delegation is
                                being introduced.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="bg-white py-24">
                    <div class="container">
                        <p
                            class="text-2xl font-bold text-teal-600 hover:text-teal-800"
                        >
                            Empowering Passive Voters through Delegation
                        </p>

                        <p
                            class="text-xl font-light leading-relaxed tracking-wide"
                        >
                            Delegation allows ADA holders to entrust their
                            voting power to one or more Delegate Representatives
                            (dReps). This system empowers passive voters,
                            enabling them to have their voices heard across a
                            broader range of proposals than they could
                            personally evaluate. dReps will play a crucial role
                            in Project Catalyst by voting on the majority of
                            proposals, enhancing decision-making quality within
                            each Fund.
                        </p>
                    </div>
                </section>

                <section class="bg-primary-20 py-24">
                    <div class="container">
                        <div class="xl:px-36">
                            <p
                                class="text-2xl font-bold text-teal-600 hover:text-teal-800"
                            >
                                Enhancing Inclusivity and Diversity through dRep
                                Recruitment
                            </p>

                            <p
                                class="text-xl font-light leading-relaxed tracking-wide"
                            >
                                IOG is reopening the application process for the
                                first dRep cohort, emphasizing inclusivity and
                                diversity. This move aims to ensure that the dRep
                                community represents the wider Cardano community's
                                diverse perspectives and expertise. As Project
                                Catalyst continues to evolve, the introduction of
                                dReps marks a significant step forward in ensuring
                                the fund's sustainability and effectiveness.
                            </p>
                            <div class="mt-4">

                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-white">
                    <div class="container">
                        <div class="py-24 sm:py-32 lg:flex lg:items-center lg:justify-between xl:px-36">
                            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                Excited for for DReps in  catalyst?
                                <br/>Jump in be a pioneer!
                            </h2>
                            <div class="mt-10 flex items-center gap-x-6 lg:mt-0 lg:flex-shrink-0">
                                <button
                                    type="button"
                                    class="inline-flex items-center gap-x-2 rounded-md bg-teal-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600"
                                >
                                    <svg
                                        class="-ml-0.5 h-5 w-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    Sign up to be a dRep
                                    <span
                                        aria-hidden="true">→</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</template>

<script>
import {defineComponent} from "vue";
import {Head} from "@inertiajs/vue3";

export default defineComponent({
    components: {Head}
})
</script>

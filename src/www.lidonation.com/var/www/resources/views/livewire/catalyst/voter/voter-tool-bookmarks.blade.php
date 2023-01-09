<x-modal formAction="saveIdea">
    <x-slot name="title">
        Bookmarks
    </x-slot>
    <x-slot name="content">
        <div>
            <section>
                <div x-data="voterTool" class="bg-white p-6">
                    <template x-for="group in proposalsByFund">
                        <section x-transition class="shadow rounded-sm mb-10">
                            <div class="bg-white sm:px-6">
                                <div
                                    class="-ml-2 -mt-2 flex py-5 justify-between items-center flex-wrap sm:flex-nowrap">
                                    <div class="ml-2 mt-2">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-12 w-12 xl:w-12 xl:h-12 rounded-sm"
                                                     :src="group.fundHero"
                                                     alt="">
                                            </div>
                                            <div class="ml-4">
                                                <h2 class="text-xl xl:text-2xl leading-6 font-medium text-gray-900">
                                                    <span x-text="group.fundTitle"></span>
                                                </h2>
                                                <div class="text-sm text-gray-500 flex flex-row gap-4">
                                                    <div>
                                                        <span>Challenge Budget:</span>
                                                        <span x-text="new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(group.fundAmount)"></span>
                                                    </div>
                                                    <div>
                                                        <span>Challenge Proposals:</span>
                                                        <span x-text="group.fundProposalsCount"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="bg-white overflow-hidden">
                                        <ul role="list" class="divide-y divide-gray-200">
                                            <template x-for="proposal in group.proposals">
                                                <li>
                                                    <div class="px-4 py-4 flex items-center sm:px-6">
                                                        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                                            <div class="truncate">
                                                                <div class="flex flex-col text-sm">
                                                                    <h3 :class="{'text-accent-700': has(proposal.id, 'upvote'), 'text-pink-600': has(proposal.id, 'downvote')}"
                                                                        class="font-medium text-lg xl:text-xl truncate" x-text="proposal.title"></h3>
                                                                    <div class="text-sm text-gray-500 flex flex-row gap-4">
                                                                        <div>
                                                                            <span>Budget:</span>
                                                                            <span x-text="new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(proposal.amount)"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ml-5 flex-shrink-0">
                                                            <div x-show="has(proposal.id, 'upvote')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent-700" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                                </svg>
                                                            </div>
                                                            <div x-show="has(proposal.id, 'downvote')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-700" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z" />
                                                                </svg>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </li>
                                            </template>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </template>
                </div>
            </section>
        </div>
    </x-slot>
</x-modal>

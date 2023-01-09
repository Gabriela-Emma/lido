<div class="relative z-10 flex inline-flex h-full gap-4 top-8" x-data="{
    showAll: true,
    onlyMine: false,
    groupRelated: false,
    filter: null,
    toggleFilter(filter) {
        this.filter = filter;
        Livewire.emit('toggleFilter', this.filter);
    },
    toggleOnlyMine() {
        this.onlyMine = !this.onlyMine;
        Livewire.emit('toggleOnlyMine');
    },
    toggleGroupRelated() {
        this.groupRelated = !this.groupRelated;
        Livewire.emit('toggleGroupRelated');
    },
    toggleMissing() {
        this.showAll = !this.showAll;
        Livewire.emit('toggleMissing');
    }}">
    <div class="flex flex-col justify-center p-2 space-y-2 border rounded-sm">
        <div class="flex items-center">
            <button type="button"
                    @click="toggleMissing"
                    :class="{'bg-gray-200': showAll, 'bg-primary-600': !showAll}"
                    class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    role="switch" aria-checked="false" aria-labelledby="only-missing-translations">
                <span aria-hidden="true"
                      :class="{
                        'translate-x-5': !showAll,
                        'translate-x-0': showAll
                      }"
                      class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0"></span>
            </button>
            <span class="ml-3" id="only-missing-translations">
                <span class="text-sm font-medium text-gray-900">Missing Translation </span>
            </span>
        </div>
    </div>
    <div class="flex flex-col justify-center p-2 space-y-2 border rounded-sm">
        <div class="flex items-center">
            <button type="button"
                    @click="toggleOnlyMine"
                    :class="{'bg-gray-200': !onlyMine, 'bg-primary-600': onlyMine}"
                    class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    role="switch" aria-checked="false" aria-labelledby="only-my-translations">
                <span aria-hidden="true"
                      :class="{
                        'translate-x-5': onlyMine,
                        'translate-x-0': !onlyMine
                      }"
                      class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0"></span>
            </button>
            <span class="ml-3" id="only-my-translations">
                <span class="text-sm font-medium text-gray-900">Only My Translations </span>
            </span>
        </div>
    </div>
    <div class="flex flex-col justify-center p-2 space-y-2 border rounded-sm">
        <div class="flex items-center">
            <button type="button"
                    @click="toggleGroupRelated"
                    :class="{'bg-gray-200': !groupRelated, 'bg-primary-600': groupRelated}"
                    class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    role="switch" aria-checked="false" aria-labelledby="only-my-translations">
                <span aria-hidden="true"
                      :class="{
                        'translate-x-5': groupRelated,
                        'translate-x-0': !groupRelated
                      }"
                      class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0"></span>
            </button>
            <span class="ml-3" id="only-my-translations">
                <span class="text-sm font-medium text-gray-900">Group Related</span>
            </span>
        </div>
    </div>

    <div class="relative flex flex-row items-center gap-2 p-2 border">
        <div class="text-sm text-gray-700 absolute -top-2 bg-gray-50 px-1.5 mb-2 rounded-sm text-xs">
            Filters
        </div>
        <div class="relative z-0 inline-flex rounded-sm p-0.5">
            <button type="button"
                    @click="toggleFilter(null)"
                    :class="{'bg-primary-600 text-white': filter === null}"
                    class="relative inline-flex items-center px-4 py-1 -ml-px text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-r-sm hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                All
            </button>
            <button type="button"
                    @click="toggleFilter('snippets')"
                    :class="{'bg-primary-600 text-white': filter === 'snippets'}"
                    class="relative inline-flex items-center px-4 py-1 -ml-px text-xs font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                Snippets
            </button>
            <button type="button"
                    @click="toggleFilter('insights')"
                    :class="{'bg-primary-600 text-white': filter === 'insights'}"
                    class="relative inline-flex items-center px-4 py-1 -ml-px text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-l-sm hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                Insights
            </button>
            <button type="button"
                    @click="toggleFilter('news')"
                    :class="{'bg-primary-600 text-white': filter === 'news'}"
                    class="relative inline-flex items-center px-4 py-1 -ml-px text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-l-sm hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                News
            </button>
            <button type="button"
                    @click="toggleFilter('reviews')"
                    :class="{'bg-primary-600 text-white': filter === 'reviews'}"
                    class="relative inline-flex items-center px-4 py-1 -ml-px text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-l-sm hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                Reviews
            </button>
            <button type="button"
                    @click="toggleFilter('onboarding')"
                    :class="{'bg-primary-600 text-white': filter === 'onboarding'}"
                    class="relative inline-flex items-center px-4 py-1 -ml-px text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-l-sm hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                Onboarding Content
            </button>
            <button type="button"
                    @click="toggleFilter('proposal')"
                    :class="{'bg-primary-600 text-white': filter === 'proposal'}"
                    class="relative inline-flex items-center px-4 py-1 -ml-px text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-l-sm hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                Proposals
            </button>
        </div>
    </div>
</div>


<div
    :class="{
        'min-h-[80rem]': !!sharingBookmark,
        'min-h-[90vh]': !sharingBookmark
    }"
    class="bg-gradient-to-br from-teal-500 via-teal-600 to-accent-900 relative text-white catalyst-proposals-bookmarks-wrapper "
    x-data="voterTool">
    @livewire('catalyst.catalyst-sub-menu-component')

    <div class="container relative h-full">
        <div x-show="loadingSharedBookmark"
             class="left-0 z-10 flex items-start justify-center w-full h-full p-32 absolute bg-teal-600 bg-opacity-90">
            <div
                class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                <svg
                    class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-teal-600"
                    viewBox="0 0 24 24"></svg>
            </div>
        </div>

        <div class="grid grid-cols-9 gap-2 relative">
            <div
                :class="{
                    'hidden lg:opacity-50 lg:block': sharingBookmark
                }"
                class="col-span-3 xl:col-span-2 p-5 text-right font-semibold text-gray-300" x-show="!viewingShareUrl">
                <div class="sticky top-16">
                    <h2 class="font-thin">Labels</h2>
                    <div>
                        <ul>
                            <li class="font-medium hover:text-white hover:cursor-pointer"
                                @click="filterProposals('all')"
                                :class="{'text-white font-semibold hover:cursor-default': labelFilter === 'all'}">
                                All
                            </li>
                            <template x-for="label in labels">
                                <li
                                    @click="filterProposals(label)"
                                    class="capitalize font-medium hover:text-white hover:cursor-pointer"
                                    :class="{'text-white font-semibold hover:cursor-default': labelFilter === label}"
                                    x-text="label"></li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
            <div
                :class="{
                    'col-span-6 xl:col-span-7': !viewingShareUrl,
                    'col-span-9': !!viewingShareUrl || !!sharingBookmark
                }"
                class=" -mt-px pt-1 mb-8 border border-teal-300">
                <div class="flex flex-row gap-3 justify-between p-5">
                    <div class="flex flex-col md:flex-row md:gap-2 md:items-center" x-show="!viewingShareUrl"
                         :class="{
                            'hidden md:flex': !!sharingBookmark
                        }">
                        <h2 class="text-sm md:text-2xl xl:text-3xl">My Bookmarks:</h2>
                        <h3 class="text-teal-200 text-md md:text-2xl xl:text-4xl uppercase" x-text="labelFilter"></h3>
                    </div>
                    <div class="flex flex-col md:flex-row md:gap-2 md:items-center" x-show="!!viewingShareUrl">
                        <h2 class="text-md md:text-2xl xl:text-3xl uppercase text-teal-200">
                            Viewing: <span class="text-teal-50" x-text="labelFilter"></span>, an anonymously shared bookmark
                        </h2>
                    </div>
                    <div x-show="!viewingShareUrl">
                        <button type="button"
                                @click="toggleSharingModal()"
                                class="inline-flex items-center px-1 py-0.5 md:px-2.5 md:py-1.5 border border-accent-700 text-xs md:text-sm font-medium rounded-sm text-slate-800 bg-accent-600 hover:bg-accent-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 md:h-4 md:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                            </svg>
                            <span>Share</span>
                        </button>
                    </div>
                </div>
                <div class="relative">
                    <div x-transition
                         x-show="addingLabel"
                         class="add-label-model-wrapper absolute w-full h-full bg-teal-600 bg-opacity-90 p-8 lg:p-16 flex justify-center items-start">
                        <div class="add-label-model bg-teal-800 text-teal-50 shadow mx-auto lg:min-w-[36rem]">
                            <h2 class="border-b border-teal-50 p-4 flex flex-row flex-nowrap items-start justify-between">
                                <span class="pr-16">
                                    <span class="font-medium text-base block">
                                        Adding Label to:
                                    </span>
                                    <span class="text-teal-600" x-text="addingLabelTo?.title"></span>
                                </span>
                                <span @click="closeLabelEditor()"
                                      class="text-white hover:cursor-pointer hover:text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                         fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </h2>

                            <div x-show="creatingLabel" x-transition class="p-4">
                                <div class="mt-4">
                                    <label for="label" class="block text-sm font-medium text-gray-100">
                                        Label
                                        <span class="text-gray-300">(Use comma to add multiple labels)</span>
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            x-model="newLabels"
                                            id="label"
                                            name="label"
                                            class="block w-full border-gray-300 bg-teal-600 rounded-sm p-2 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>

                            <div x-show="!creatingLabel" x-transition class="type-filter w-full p-4" x-data="{
                                    options: labels.map((l) => ({value: l, label: l})),
                                    init() {
                                        this.$nextTick(() => {
                                            let choices = new Choices(
                                                this.$refs.select,
                                                {
                                                    position: 'bottom',
                                                    placeholderValue: 'Select Label',
                                                    duplicateItemsAllowed: false,
                                                    removeItemButton: true
                                                }
                                            );

                                            let refreshChoices = () => {
                                                let selection = addingLabelTo?.labels || [];

                                                choices.clearStore()
                                                choices.setChoices(this.options.map(({ value, label }) => ({
                                                    value,
                                                    label,
                                                    selected: selection.includes(value)
                                                })));
                                            }

                                            refreshChoices();

                                            this.$refs.select.addEventListener('change', () => {
                                                this.selectedLabels = choices.getValue(true);
                                                this.filters = this.selectedLabels.map( (c) => (c.value));
                                            })

                                            this.$watch('addingLabelTo', () => refreshChoices());
                                            this.$watch('options', () => refreshChoices());
                                        })
                                    }
                                }">
                                <select x-ref="select" :multiple="true"></select>

                                <span @click="createLabel()" class="text-sm relative -top-6 z40 hover:cursor-pointer">New Label</span>
                            </div>

                            <div class="p-4 border-t border-teal-50">
                                <button
                                    @click="saveLabels()"
                                    type="button"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                    <div x-transition x-show="sharingBookmark"
                        class="add-label-model-wrapper md:absolute w-full h-full bg-teal-600 bg-opacity-90 lg:p-16 flex justify-center items-start">
                        <div class="add-label-model text-teal-50 shadow mx-auto lg:min-w-[36rem] relative" >

                            <button type="button"
                                    @click="toggleSharingModal()"
                                    class="inline-flex items-center px-2 py-1 border absolute right-4 top-4 border-transparent text-xs font-medium rounded-sm text-slate-200 bg-teal-700 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-600">
                                Close
                            </button>

                            <div class="bg-teal-900">
                                <div class="pt-12 sm:pt-16 lg:pt-20">
                                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                        <div class="text-center">
                                            <h2 class="text-2xl tracking-tight font-bold text-slate-300 sm:text-4xl sm:tracking-tight lg:text-5xl lg:tracking-tight">
                                                <span>Share Bookmark</span>
                                                <span x-text="`: ${labelFilter}`" class="font-semibold uppercase text-slate-100"></span>
                                            </h2>
                                            <p class="mt-4 text-md md:text-xl text-slate-200">
                                                Sharing your bookmark will generate a link you can share with others.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8 bg-teal-700 pb-16 sm:mt-12 sm:pb-20 lg:pb-28">
                                    <div class="relative">
                                        <div class="absolute inset-0 h-1/2 bg-teal-900"></div>
                                        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                            <div class="max-w-lg mx-auto rounded-sm shadow-lg overflow-hidden lg:max-w-none lg:flex">

                                                <div class="flex-1 bg-teal-600 px-6 py-4 md:py-8 lg:p-12">
                                                    <h3 class="text-2xl font-bold text-slate-100 sm:text-3xl sm:tracking-tight">
                                                        Things to know
                                                    </h3>
                                                    <p class="mt-2 md:mt-6 text-base text-slate-200">
                                                        Generating link will embed all of your bookmarks in the url.
                                                        Since browsers and servers have limitation on url length, the long url will be saved to our server.
                                                        You get a unique short url to share.
                                                    </p>
                                                    <p>
                                                        Anyone with that url can see and display the embedded proposals on this page.
                                                    </p>
                                                    <div class="mt-5 md:mt-8">
                                                        <div class="flex items-center">
                                                            <h4 class="flex-shrink-0 pr-4 bg-teal-600 text-base font-semibold text-teal-600">
                                                                Ready to Generate
                                                            </h4>
                                                            <div class="flex-1 border-t-2 border-teal-200"></div>
                                                        </div>
                                                        <ul role="list" class="mt-8 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-5">
                                                            <li class="flex items-start lg:col-span-1">
                                                                <div class="flex-shrink-0 relative w-5 h-5">
                                                                    <!-- Heroicon name: solid/check-circle -->
                                                                    <svg x-show="generatingAnonShare.includes(1)" class="h-5 w-5 text-teal-600 absolute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    <svg x-show="!generatingAnonShare.includes(1)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                                    </svg>
                                                                </div>
                                                                <p class="ml-3 text-sm text-slate-200">
                                                                    Converting to base64 blob.
                                                                </p>
                                                            </li>

                                                            <li class="flex items-start lg:col-span-1">
                                                                <div class="flex-shrink-0 relative w-5 h-5">
                                                                    <svg x-show="generatingAnonShare.includes(2)" class="h-5 w-5 text-teal-600 absolute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    <svg x-show="!generatingAnonShare.includes(2)" xmlns="http://www.w3.org/2000/svg" class="absolute h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                                    </svg>
                                                                </div>
                                                                <p class="ml-3 text-sm text-slate-200">
                                                                    Submitting to backend.
                                                                </p>
                                                            </li>

                                                            <li class="flex items-start lg:col-span-1">
                                                                <div class="flex-shrink-0 relative w-5 h-5">
                                                                    <svg x-show="generatingAnonShare.includes(3)" class="h-5 w-5 text-teal-600 absolute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    <svg x-show="!generatingAnonShare.includes(3)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                                    </svg>
                                                                </div>
                                                                <p class="ml-3 text-sm text-slate-200">
                                                                    Getting short sharable link.
                                                                </p>
                                                            </li>

                                                            <li class="flex items-start lg:col-span-1">
                                                                <div class="flex-shrink-0 relative w-5 h-5">
                                                                    <svg x-show="generatingAnonShare.includes(4)" class="h-5 w-5 text-teal-600 absolute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    <svg x-show="!generatingAnonShare.includes(4)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                                    </svg>
                                                                </div>
                                                                <p class="ml-3 text-sm text-slate-200">
                                                                    Link ready to share.
                                                                </p>
                                                            </li>
                                                        </ul>

                                                        <div id="bookmarkLink" class="mt-8 flex flex-row gap-2" x-show="!!bookmarkShareUrl">
                                                            <h2 class="text-teal-800 text-2xl xl:text-4xl flex flex-col">
                                                                <span>Link</span>
                                                                <a
                                                                    target="_blank"
                                                                    class="break-all text-sm md:text-lg text-slate-100"
                                                                    :href="bookmarkShareUrl"
                                                                    x-text="bookmarkShareUrl"></a>
                                                            </h2>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="py-6 px-4 text-center bg-accent-700 lg:flex-shrink-0 lg:flex lg:flex-col lg:justify-center lg:p-16">
                                                    <div class="w-full flex flex-row justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="h-24 w-24 text-accent-900"
                                                             viewBox="0 0 20 20"
                                                             fill="currentColor">
                                                            <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="mt-4">
                                                        <div class="rounded-sm shadow">
                                                            <a href="#bookmarkLink"
                                                               @click.prevent="share()"
                                                               class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-sm text-white hover:text-slate-200 bg-slate-800 hover:bg-slate-900">
                                                                Generate Link
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <template x-if="!proposalsByFund?.length">
                        <section class="border-t border-teal-300 p-6" x-transition>
                            <div class="flex flex-col gap-4 items-center">
                                <h2>You haven't bookmarked anything yet!</h2>
                                <p>
                                    As you're researching proposal, for voting, or any other reason,
                                    you may bookmark and assign labels to proposals you wish to revisit.
                                    When you do, those proposals will show up here!
                                </p>
                                <p>Happy researching!</p>
                            </div>
                        </section>
                    </template>
                    <template x-for="group in proposalsByFund">
                        <section class="border-t border-teal-300 p-2 md:p-6" x-transition>
                            <div class="flex md:items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-6 w-6 md:h-12 md:w-12 xl:w-12 xl:h-12 rounded-sm"
                                         :src="group.fundHero"
                                         alt="">
                                </div>
                                <div class="ml-2 md:ml-4">
                                    <h2 class="text-md md:text-xl xl:text-2xl md:leading-6 font-medium">
                                        <span x-text="group.fundTitle"></span>
                                    </h2>
                                    <div class="text-xs md:text-sm text-gray-100 flex flex-row gap-4">
                                        <div>
                                            <span class="font-medium">Challenge Budget:</span>
                                            <span
                                                class="font-semibold"
                                                x-text="new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(group.fundAmount)"></span>
                                        </div>
                                        <div>
                                            <span class="font-medium">Challenge Proposals:</span>
                                            <span class="font-semibold" x-text="group.fundProposalsCount"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul role="list" class="divide-y divide-teal-400 mt-6 md:space-y-4 mt-4 md:mt-6 md:mr-16">
                                <template x-for="proposal in group.proposals">
                                    <li class="flex flex-rows group">
                                        <div class="w-10 md:w-16" x-show="!!viewingShareUrl"></div>
                                        <div @click="bookmarkProposal(proposal)"
                                             x-show="!viewingShareUrl"
                                             class="w-10 md:w-16 flex justify-start invisible group-hover:visible items-center mt-1 text-slate-400 hover:cursor-pointer hover:text-slate-100">
                                            <div class="text-xs flex flex-col justify-center items-center h-full">
                                                <span class="hidden md:inline-block">Remove</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="pt-4 flex items-center justify-between w-full">
                                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between group">
                                                <div class="md:truncate flex flex-row flex-wrap items-start gap-4 md:gap-8">
                                                    <div class="flex flex-col text-sm">
                                                        <h3 :class="{'text-accent-700': has(proposal.id, 'upvote'), 'text-gray-800': has(proposal.id, 'downvote')}"
                                                            class="font-medium text-md md:text-lg xl:text-xl md:truncate"
                                                            x-text="proposal.title"></h3>
                                                        <div class="text-sm text-gray-100 flex flex-col md:flex-row gap-2 md:gap-4">
                                                            <div>
                                                                <span class="font-medium">Budget:</span>
                                                                <span
                                                                    class="font-semibold"
                                                                    x-text="new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(proposal.amount)"></span>
                                                            </div>
                                                            <div class="text-xs flex flex-row flex-wrap gap-1">
                                                                <template x-for="label in (proposal?.labels || [])">
                                                                    <span
                                                                        @click="removeLabels(proposal, [label])"
                                                                        class="inline-flex items-center py-0.5 px-1 rounded-sm font-medium bg-teal-100 text-teal-800">
                                                                        <span x-text="label"></span>
                                                                        <span class="hover:cursor-pointer hover:text-yellow-900">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 md:h-5 md:w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                            </svg>
                                                                        </span>
                                                                    </span>
                                                                </template>
                                                                <span
                                                                    @click="addLabels(proposal)"
                                                                    class="inline-flex items-center p-0.5 rounded-sm font-medium bg-transparent border border-teal-100 border-dotted text-teal-50 hover:cursor-pointer hover:text-yellow-500">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         class="h-3 w-3" viewBox="0 0 20 20"
                                                                         fill="currentColor">
                                                                      <path fill-rule="evenodd"
                                                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                                            clip-rule="evenodd"/>
                                                                    </svg>
                                                                  Add Label
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="actions lg:invisible group-hover:visible flex flex-row items-center pt-1 gap-3">
                                                        <a
                                                            :href="proposal?.link" type="button" target="_blank"
                                                            class="inline-flex items-center px-2 py-1 mb-2 border border-teal-300 text-xs font-medium rounded-sm text-slate-100 hover:text-teal-200 focus:outline-none focus:ring-0">
                                                            View Proposal
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="md:ml-5 mb-3 md:mb-0 mt-auto md:mt-0 flex-shrink-0">
                                                <div x-show="has(proposal.id, 'upvote')">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-accent-700" viewBox="0 0 20 20"
                                                         fill="currentColor">
                                                        <path
                                                            d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                                    </svg>
                                                </div>
                                                <div x-show="has(proposal.id, 'downvote')">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-gray-800" viewBox="0 0 20 20"
                                                         fill="currentColor">
                                                        <path
                                                            d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"/>
                                                    </svg>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </section>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

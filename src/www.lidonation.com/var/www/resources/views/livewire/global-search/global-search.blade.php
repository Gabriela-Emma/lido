<div class="h-full pb-20 relative z-40" x-data="globalSearch">
    <header class="relative h-20 border-b border-gray-300">
        <span @click="$dispatch('close-global-search')"
              class="absolute top-0 right-0 p-2 font-semibold text-white hover:cursor-pointer bg-primary-600 hover:bg-teal-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"/>
            </svg>
        </span>
        <div class="w-full h-full">
            <form method="POST" class="w-full h-full"  @submit.prevent>
                <div class="flex flex-col justify-between h-full gap-1">
                    <label for="search" class="block px-3 pt-2 font-medium font-semibold text-gray-900 text-md">Search</label>
                    <input type="search" onkeydown="return (event.keyCode!=13);" name="search" id="search" x-model.debounce.400ms="search"
                           class="block w-full h-10 p-3 text-gray-900 placeholder-gray-500 border-0 border-t border-b border-gray-300 focus:ring-0 sm:text-sm"
                           placeholder="News, Insights, Reviews">
                </div>
            </form>
        </div>
    </header>

    <nav class="h-full overflow-y-auto" aria-label="Directory" x-show="results">
        <template x-for="group in results" :key="group.type">
            <div class="relative">
                <div
                    class="sticky top-0 z-10 px-6 py-1 text-sm font-medium text-gray-500 border-t border-b border-gray-200 bg-gray-50">
                    <h3 class="capitalize" x-text="group.type"></h3>
                </div>
                <ul role="list" class="relative z-0 divide-y divide-gray-200">
                    <template x-for="item in group.items" :key="item.id">
                        <li class="bg-white" x-transition>
                            <div
                                class="relative flex items-center px-6 py-5 space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-primary-500">
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full bg-teal-800"
                                         :src="getThumbnail(item)"
                                         alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <a :href="item.link" class="focus:outline-none hover:text-teal-700">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        <div class="text-sm font-semibold text-gray-900"
                                             x-text="item.title + (group.type === 'reviews' ? ' Review' : '')"></div>
                                        <div class="flex items-center gap-1 text-xs rounded-sm post-meta">
                                            <div class="text-gray-500 bg-gray-100 px-1 py-0.5"
                                                 x-text="item.published_at"></div>
                                            <div  x-show="group.type != 'reviews'" class="rounded-sm bg-gray-100 px-1 py-0.5"
                                                 x-html="item.read_time"></div>
                                            <div class="inline-flex items-center rounded-sm gap-1 author bg-gray-100 px-1 py-0.5" x-show="group.type != 'reviews'">
                                                <div class="inline-block bio-pic">
                                                    <img class="w-4 h-4 rounded-full"
                                                         :src="item.author_gravatar"
                                                         :title="item.author_name"
                                                         :alt="item.author_name + ' Bio Pic'" />
                                                </div>
                                                <div class="author-name"
                                                     x-text="item.author_name"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </template>
    </nav>

    <div class="absolute w-full p-8 top-20 h-50" x-transition x-show="working">
        <div class="flex items-center justify-center h-full p-16 mx-auto">
            <svg
                class="relative w-10 h-10 mx-auto border-t-2 border-b-2 rounded-full animate-spin border-primary-600 -top-4"
                viewBox="0 0 24 24"></svg>
        </div>
    </div>

    <div class="p-6" x-show="!results && noResults">
        <div
            class="relative flex flex-col items-center justify-center w-full p-12 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <span class="block mt-2 text-sm font-medium text-gray-900">
                Nothing came up for <span class="font-semibold" x-text="search"></span>
            </span>
        </div>
    </div>

    <script type="text/javascript">
        window.globalSearch = function globalSearch() {
            return {
                search: '',
                results: null,
                noResults: false,
                working: false,
                locale: '{{ $locale }}',
                init: function () {
                    this.$watch('search', this.runSearch.bind(this));
                    // this.$focus('search');
                },
                getThumbnail(item) {
                    return item?.thumbnail || '/img/bleu.png';
                },
                runSearch: async function (value, oldValue) {
                    this.working = true;
                    const res = await axios.get(`/${this.locale}/search/${value}`);
                    const data = await res.data;
                    if (data.length) {
                        this.results = data;
                    } else {
                        this.results = null;
                        this.noResults = true;
                    }
                    this.working = false;
                    window.fathom.trackGoal('T9S57PLY', 0);
                }
            }
        }
    </script>
</div>


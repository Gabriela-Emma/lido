<script type="text/javascript">
    window.slteModal = function () {
        return {
            modalShown: Alpine.$persist(localStorage.getItem('slteModalShown') ?? 0).as('slteModalShown'),
            showing: false,
            lang: document.getElementsByTagName("html")[0].getAttribute("lang"),
            modalId: document.querySelector('#slteModal'),
            show() {
                if (this.modalShown != 1 && this.lang == 'sw') {
                    this.modalId.style.display = 'block';
                    this.showing = true;
                    this.modalShown = 1;
                } else {
                    this.modalId.style.display = 'none';
                }
            }
        };
    }
</script>
<div x-data="slteModal()"
     x-init="$nextTick(() => show())"
     style="display:none"
     id="slteModal"
     @keydown.escape="showing = false">
    <div
        class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
        x-show="showing"
    >
        <div
            class="bg-gradient-to-b from-teal-900 to-teal-500 w-auto flex flex-col rounded-sm relative overflow-clip">
            <div class="flex items-start justify-between p-4 border-b border-teal-200">
                <h2 class="font-medium text-gray-300 w-auto brightness-100 ">
                    Inakuja hivi karibuni
                </h2>

                <button type="button" class="z-50 cursor-pointer hover:text-white absolute right-4 top-4" @click="showing = false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="relative min-w-[32rem] max-w-7xl mx-auto p-4">
                <div class="flex flex-col gap-8 text-slate-100">
                    <div>
                        <div class="text-white flex gap-4 items-start">
                            <div class="w-10 h-10 bg-white text-slate-800 rounded-full flex justify-center items-center font-semibold">
                                1
                            </div>
                            <div>
                                <h2 class="text-white flex gap-2 items-center">
                                    <span>Learn</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-yellow-50">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                                    </svg>
                                </h2>
                                <div class="max-w-sm">
                                    <p>
                                        Read an article about blockchain in plain Swahili.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="text-white flex gap-4 items-start">
                            <div class="w-10 h-10 bg-white text-slate-800 rounded-full flex justify-center items-center font-semibold">
                                2
                            </div>
                            <div>
                                <h2 class="text-white flex gap-2 items-center">
                                    <span>Quiz</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>
                                </h2>
                                <div class="max-w-md">
                                    <p>
                                        Answer a few multiple-choice questions about the article. No trick questions, we promise.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div>
                        <div class="text-white flex gap-4 items-start">
                            <div class="w-10 h-10 bg-white text-slate-800 rounded-full flex justify-center items-center font-semibold">
                                3
                            </div>
                            <div>
                                <h2 class="text-white flex gap-2 items-center">
                                    <span>Earn</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </h2>
                                <div class="max-w-sm">
                                    <p>
                                        Once you pass the quiz, you earn ada. Complete modules, earn nft bonuses.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="flex justify-center w-full p-4 mt-4">
                    <a type="button" href="{{localizeRoute('earn.learn')}}"
                       class="inline-flex items-center gap-x-2 rounded-sm bg-labs-red px-3.5 py-2.5 text-sm xl:text-xl font-semibold text-white hover:text-black shadow-sm hover:bg-labs-red-light focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-labs-red-light">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>
                </footer>
            </div>
        </div>
    </div>
</div>

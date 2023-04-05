<script type="text/javascript">
    window.slteModal = function () {
        return {
            modalShown: Alpine.$persist(localStorage.getItem('slteModalShown') ?? 0).as('slteModalShown'),
            showing: false,
            lang: document.getElementsByTagName("html")[0].getAttribute("lang"),
            modalId: document.querySelector('#slteModal'),
            show() {
                // if (this.modalShown != 1 && this.lang == 'sw') {
                if (this.lang == 'sw') {
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
            <div class="flex items-start justify-between p-3 border-b border-teal-100">
                <h2 class="font-medium text-gray-300 w-auto brightness-100 ">
                    Learn and earn Crypto
                </h2>

                <button type="button" class="z-50 cursor-pointer hover:text-white absolute right-3 top-3" @click="showing = false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>


            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-16">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col items-center">
                        <h1 class="font-medium text-gray-300 w-auto brightness-100 ">
                           Learn and earn Crypto
                        </h1>
                        <p class="mt-4 mb-4 text-md text-gray-300 w-3/5">
                            Swahili Learn To Earn
                        </p>
                    </div>
                </div>

                <div class="max-w-lg mx-auto rounded-sm shadow-lg overflow-hidden lg:max-w-none lg:flex">
                    <div class="flex-1 bg-teal-500">
                        <div class="flex justify-between w-full">
                            <div class="flex items-center p-4 w-auto text-white">
                                Inakuja hivi karibuni.
                            </div>
                            <div class="bg-teal-600 ml-auto">
                                <div class="bg-slate-100 login-form-wrapper">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pointer-events-none" x-data="{
    notices: [],
    handlePushNotice(e) {
        let error = {};
        if (typeof e ==='string') {
            error.name = 'Error';
            error.message = e;
            error.type = 'error';
        } else {
            error = e;
        }
        this.notices = [
            {
                type: 'default',
                ...error
            },
            ...this.notices
        ];
    },
    clearError() {
        if (this.notices.length === 1) {
            this.notices = [];
        } else {
            const notices = this.notices.splice(index, 1);
            this.notices = [...notices];
        }
    },
    delay(ms) {
        return new Promise(res => setTimeout(res, ms));
    }
}">
    <div class="flex flex-col gap-6 justify-end items-end pointer-events-none"
         @new-notice.window="handlePushNotice($event?.detail)">
        <template x-for="(notice, index) in notices">
            <div
                :class="{
                    'bg-white text-slate-800': notice.type === 'default',
                    'bg-yellow-800 text-white': notice.type === 'info',
                    'bg-teal-600 text-white': notice.type === 'success',
                    'bg-red-500 text-white': notice.type === 'error'
                }"
                x-transition.delay.700ms
                class="max-w-sm w-full shadow-lg rounded-sm pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: outline/check-circle -->
                            <svg x-show="notice.type === 'success'"
                                 class="h-6 w-6"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>

                            <svg x-show="notice.type === 'error'"
                                 xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-lg font-semibold" x-text="notice.name">Notice!</p>
                            <p class="text-sm" x-html="notice.message"></p>
                        </div>

                        <div class="ml-4 flex-shrink-0 flex">
                            <button
                                @click="clearError(index)"
                                type="button"
                                class="bg-white rounded-sm inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                <span class="sr-only">Close</span>
                                <!-- Heroicon name: solid/x -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

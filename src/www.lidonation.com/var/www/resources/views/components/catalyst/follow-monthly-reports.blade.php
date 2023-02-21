@props(['model', 'filter' => 'proposal'])
<div class="flex flex-col justify-center gap-4 relative p-3" x-data="{
    subject: @js($model->id),
    filter: @js($filter),
    proposal: null,
    group: null,
    user: null,
    showForm: false,
    error: false,
    completed: false,
    processing: false,

    init() {

    },

    async followReport(event) {
        this.processing = true;
        const subscription = {
            ...Object.fromEntries(new FormData(event.target)),
            filter: this.filter,
            value: this.subject
        };
        const res = await window.axios.post(`/api/catalyst-explorer/reports/follow`, subscription);
        this.processing = false;
        if ([200, 201].includes(res.status)) {
            this.showForm = false;
            this.completed = true;
        } else {
            this.error = true;
        }
    }
    }"
     :class="{
        'border border-teal-600': showForm
   }">
    <div class="absolute left-0 top-0 py-24 w-full h-full flex justify-center items-center z-30 bg-white/75"
         x-show="processing" x-transition>
        <div class="w-52 h-52 p-10 rounded-full">
            <x-theme.spinner square="28"/>
        </div>
    </div>

    <div class="rounded-sm bg-red-400 p-4" x-show="error">
        <div class="flex">
            <div class="flex-shrink-0">
                <!-- Heroicon name: mini/x-circle -->
                <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm xl:text-md font-medium text-white">
                    Error following <bold class="text-slate-800">{{$model->title}}</bold>. Please again later.
                </p>
            </div>
        </div>
    </div>

    <div class="rounded-sm bg-green-400 p-4" x-show="completed">
        <div class="flex">
            <div class="flex-shrink-0">
                <!-- Heroicon name: mini/check-circle -->
                <svg class="h-5 w-5 text-teal-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm xl:text-md font-bold text-white">
                    Successfully subscribed. Watch your inbox!
                </p>
            </div>
        </div>
    </div>

    <div class="w-full text-center" x-show="!showForm && !completed && !error" x-transition>
        <a href="#" @click.prevent="showForm = !showForm"
           class="text-sm xl:text-base border border-teal-600 p-2 inline-flex uppercase mx-auto">
            Get reports in your email
        </a>
    </div>

    <div x-show="showForm" x-transition>
        <div class="text-center mx-auto">
            <p class="text-base font-medium">
                We will check for new reports and deliver them directly in your email.
            </p>
        </div>

        <form @submit.prevent="followReport" class="flex flex-col justify-center w-full rounded-md gap-4 w-full my-4">
            <div class="w-full rounded-l-md">
                <label for="name" class="sr-only">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    autocomplete="name"
                    required
                    class="custom-input w-full input h-full border-teal-100 active:border-teal-600 focus:border-teal-600 focus:ring-teal-600"
                    placeholder="What should we call you?">
            </div>

            <div class="w-full rounded-l-md">
                <label for="where" class="sr-only">Email address</label>
                <input
                    type="email"
                    name="where"
                    id="where"
                    autocomplete="email"
                    required
                    class="custom-input w-full input h-full border-teal-100 active:border-teal-600 focus:border-teal-600 focus:ring-teal-600"
                    placeholder="Your email">
            </div>

            <div class="rounded-r-md">
                <button type="submit"
                        class="hover:bg-white w-full custom-input inline-flex h-full button primary mt-0">
                    Subscribe
                </button>
            </div>

            @csrf
        </form>

        <div class="text-center mx-auto">
            <p class="text-slate-500 text-sm">
                Your email will not be shared with any 3rd party or be used for anything else.
            </p>
        </div>
    </div>
</div>

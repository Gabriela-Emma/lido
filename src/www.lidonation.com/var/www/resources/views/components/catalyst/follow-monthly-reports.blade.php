@props(['model'])
<div class="flex flex-col gap-4 p-8" x-data="{
    whatType: @js($model::class),
    proposal: null,
    group: null,
    user: null,
    showForm: true,
    processing: false,

    init() {

    },

    async followReport(event) {
        const subscription = {
            what_type: this.whatType,
            ...Object.fromEntries(new FormData(event.target))
        };
        console.log(subscription);
{{--        const res = await window.axios.post(`/api/lido-minute-nft/mint`, {--}}
{{--        hash: this.paymentTx,--}}
{{--        episode: id--}}
{{--      });--}}

    }
    }"
     :class="{
        'border border-teal-600': showForm
   }">
    <div class="w-full text-center" x-show="!showForm" x-transition>
        <a href="#" @click.prevent="showForm = !showForm"
           class="text-sm xl:text-base border border-teal-600 py-2 px-4 inline-flex uppercase mx-auto">
            Get reports in your email
        </a>
    </div>

    <div x-show="showForm" x-transition>
        <div class="w-80 text-center mx-auto">
            <p class="text-base font-medium">
                We will check for new reports and deliver them directly in your email.
            </p>
        </div>

        <form @submit.prevent="followReport" class="flex flex-col justify-center w-full rounded-md gap-4 w-96 my-4">
            <div class="w-full rounded-l-md">
                <label for="emailAddress" class="sr-only">Name</label>
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
                <label for="emailAddress" class="sr-only">Email address</label>
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

        <div class="text-center w-80 mx-auto">
            <p class="text-slate-500 text-sm">
                Your email will not be shared with any 3rd party or be used for anything else.
            </p>
        </div>
    </div>
</div>

<div class="flex flex-col gap-4" x-data="{
    proposal: null,
    group: null,
    user: null,
    showForm: true,
    processing: false,

    init() {

    },
    followReport() {

    }}">
    <div class="w-full text-center" x-show="!showForm" x-transition>
        <a href="#" @click.prevent="showForm = !showForm" class="text-sm xl:text-base border border-teal-600 py-2 px-4 inline-flex uppercase mx-auto">
            Get reports in your email
        </a>
    </div>

    <div x-show="showForm" x-transition>
        <form class="flex flex-col justify-center w-full rounded-md gap-4 w-80">
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
                    name="emailAddress"
                    id="emailAddress"
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
    </div>
</div>

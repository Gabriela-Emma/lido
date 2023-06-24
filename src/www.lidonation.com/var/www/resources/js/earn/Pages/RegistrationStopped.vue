<template>
    <Modal :show="show">
        <div class="z-50 flex flex-col bg-labs-red">
            <header class="p-6 text-white bg-labs-black text-md">
                <h2>Usajili haufanyiki kwa sasa.</h2>
            </header>

            <div class="flex items-center gap-2 px-8 py-10 sm:px-16">
                <!-- <div
                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                >
                    <ExclamationTriangleIcon
                        class="w-6 h-6 text-red-600"
                        aria-hidden="true"
                    />
                </div> -->
                <div class="flex flex-col gap-6">
                    <div>
                        <p class="text-white text-md">
                            Our first cohort of Learn-to-Earn users is full!
                        </p>
                        <p class="text-white text-md">
                            Sign up below to be placed on the waiting list to be
                            notified of future learn-to-earn opportunities
                        </p>
                    </div>

                    <form v-if="showForm" @submit.prevent="submit" class="flex flex-col gap-4 p-4 text-black round-sm bg-labs-black/50">
                        <div class="">
                            <label
                                for="name"
                                class="block text-sm font-medium text-white"
                                >{{ $t("Name") }}
                            </label>
                            <div class="mt-1">
                                <input
                                    v-model="name"
                                    v-text="form.errors.name"
                                    id="name"
                                    name="name"
                                    type="text"
                                    autocomplete="name"
                                    required
                                    class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.name"
                                    v-text="form.errors.name"
                                    class="p-2 mt-1 text-xs text-red-500 bg-white"
                                ></div>
                            </div>
                        </div>
                        <div class="">
                            <label
                                for="email"
                                class="block text-sm font-medium text-white"
                                >{{ $t("Email address") }}
                            </label>
                            <div class="mt-1">
                                <input
                                    v-model="email"
                                    id="email"
                                    name="email"
                                    type="email"
                                    autocomplete="email"
                                    required
                                    class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.email"
                                    v-text="form.errors.email"
                                    class="p-2 mt-1 text-xs text-red-500 bg-white"
                                ></div>
                            </div>
                        </div>
                        <div class="">
                            <button
                                type="submit"
                                class="flex items-center justify-center w-full gap-3 px-2 py-1 font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm text-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-7 h-7"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"
                                    />
                                </svg>
                                <span>{{ $t("Enroll") }}</span>
                            </button>
                        </div>
                    </form>

                    <div class="p-4 text-white round-sm bg-labs-black/50" v-if="!showForm" >
                        <p class="text-white text-md">
                            Check your email after you enroll for a link to set your
                            password and checkout other ways to earn on lido nation!
                        </p>
                    </div>

                    <div class="flex justify-center">
                        <Link
                            href="/earn"
                            class="px-2 py-2 font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm text-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        >
                            Other Ways to Earn
                        </Link>
                    </div>
                </div>
            </div>

            <div class="flex justify-center w-full gap-3 my-3 text-md">
                <span>Tayari una akaunti{{ $t("") }}?</span>
                <Link
                    href="/earn/learn/login"
                    class="px-2 font-bold border-none text-labs-yellow hover:text-labs-yellow-light"
                >
                    {{ $t("Sign in") }}
                </Link>
            </div>
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import Modal from "../../global/Shared/Components/Modal.vue";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { useForm, usePage } from "@inertiajs/vue3";
import User from "../../global/Shared/Models/user";

const params = new URLSearchParams(window.location.search);;

let show = ref(true);
const user = computed(() => usePage().props.user as User);

let name = ref(null);
let email = ref(null);
let showForm = ref(!params.get('waitlisted'));

if (user) {
    name.value = user.value?.name;
    email.value = user.value?.email;
}

let form = useForm({
    name,
    email,
});

const baseUrl = usePage().props.base_url;
let submit = () => {
    form.post(`${baseUrl}/api/earn/learn/waitList`, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            showForm.value = false;
        },
    });
};
</script>

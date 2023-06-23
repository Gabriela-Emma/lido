<template>
    <Modal :show="show">
        <div class="z-50 bg-labs-red flex flex-col">
            <header class="p-6 bg-labs-black text-white text-md">
                <h2>Usajili haufanyiki kwa sasa.</h2>
            </header>

            <div class="px-8 py-16 sm:px-24 flex items-center gap-2">
                <div
                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                >
                    <ExclamationTriangleIcon
                        class="h-6 w-6 text-red-600"
                        aria-hidden="true"
                    />
                </div>
                <div>
                    <p class="text-md text-white">
                        Our first cohort of Learn-to-Earn users is full!
                    </p>
                    <p class="text-md text-white">
                        Sign-up below to be placed on the waiting list to be
                        notified of future learn-to-earn opportunities
                    </p>
                    <form v-if="showForm">
                        <div class="mb-2">
                            <label
                                for="name"
                                class="block text-sm font-medium text-black"
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
                                    class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.name"
                                    v-text="form.errors.name"
                                    class="text-red-500 text-xs mt-1 bg-white p-2"
                                ></div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label
                                for="email"
                                class="block text-sm font-medium text-black"
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
                                    class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.email"
                                    v-text="form.errors.email"
                                    class="text-red-500 text-xs mt-1 bg-white p-2"
                                ></div>
                            </div>
                        </div>
                        <div class="">
                            <button
                                @click.prevent="submit"
                                type="submit"
                                class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-teal-600 py-1 px-2 text-md font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
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
                    <p v-if="!user" class="text-md text-white">
                        Check your email after you enroll for a link to set your
                        password and checkout other ways to earn on lido nation!
                    </p>
                    <div>
                        <p class="text-md text-white mb-1">
                            Try our Every Epoch quiz or other ways to earn on
                            lidonation.
                        </p>
                        <Link
                            href="/earn"
                            class="rounded-sm border border-transparent bg-teal-600 py-1 px-2 text-md font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        >
                            Other Ways to Earn
                        </Link>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 text-md w-full justify-center mb-3">
                <span>Tayari una akaunti{{ $t("") }}?</span>
                <Link
                    href="/earn/learn/login"
                    class="font-bold text-teal-600 hover:text-teal-700 border-none px-2"
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

let show = ref(true);
const user = computed(() => usePage().props.user as User);

let name = ref(null);
let email = ref(null);
let showForm = ref(true);

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
        onSuccess: () => {
            showForm.value = false;
        },
    });
};
</script>

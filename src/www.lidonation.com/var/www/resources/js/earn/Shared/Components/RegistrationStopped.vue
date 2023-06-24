<template>
    <NonRouteModal :isOpen="show">
        <div class="z-50 flex flex-col bg-labs-red">
            <header class="p-6 text-white bg-labs-black text-md">
                <h2>Usajili haufanyiki kwa sasa.</h2>
            </header>

            <div class="flex items-center gap-2 px-8 py-10 sm:px-16">
                <div class="flex flex-col gap-6">
                    <div>
                        <p class="text-white text-md">
                            Kundi letu la kwanza la watumiaji wa "Learn-to-Earn"
                            limejaa!
                        </p>
                        <p class="text-white text-md">
                            Jisajili hapa chini ili uwekwe kwenye orodha ya
                            kusubiri ndiposa ujulishwe kuhusu fursa za baadaye
                            za kujisajili.
                        </p>
                    </div>

                    <form
                        v-if="showForm"
                        @submit.prevent="submit"
                        class="flex flex-col gap-4 p-4 text-black round-sm bg-labs-black/50"
                    >
                        <div class="">
                            <label
                                for="name"
                                class="block text-sm font-medium text-white"
                                >Jina
                            </label>
                            <div class="mt-1">
                                <input
                                    v-model="name"
                                    id="name"
                                    name="name"
                                    type="text"
                                    autocomplete="name"
                                    required
                                    class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                />
                            </div>
                        </div>
                        <div class="">
                            <label
                                for="email"
                                class="block text-sm font-medium text-white"
                                >barua pepe
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
                            </div>
                        </div>
                        <div
                            v-if="showErrors"
                            class="p-2 mt-1 text-xs text-red-500 bg-white"
                        >
                            <span
                                >Kumetokea kosa wakati wa kuwasilisha ombi lako,
                                jaribu tena!</span
                            >
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
                                <span>Jisajili</span>
                            </button>
                        </div>
                    </form>

                    <div
                        class="p-4 text-white round-sm bg-labs-black/50"
                        v-if="!showForm"
                    >
                        <p class="text-white text-md">
                            Angalia barua pepe yako baada ya kujiandikisha ili
                            kuweka nenosiri lako mpya ikiwa wewe ni mtumiaji mpya kisha
                            angalia njia nyingine za kupata mapato kwenye Lido
                            Nation!
                        </p>
                        <p class="text-white text-md">
                            Umefanikiwa kuongezwa kwenye orodha ya kusubiri ya "Learn-to-Earn".
                        </p>
                    </div>

                    <div class="flex justify-center">
                        <Link
                            href="/earn"
                            class="px-2 py-2 font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm text-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        >
                            <span class="text-white">Njia nyingine za kupata mapato</span>
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
    </NonRouteModal>
</template>

<script lang="ts" setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import User from "../../../global/Shared/Models/user";
import NonRouteModal from "../../../global/Shared/Components/NonRouteModal.vue";
import axios from "../../../lib/utils/axios";
import route from "ziggy-js";

const props = withDefaults(
    defineProps<{
        show?: boolean;
    }>(),
    {}
);

const user = computed(() => usePage().props.user as User);

let name = ref(null);
let email = ref(null);
let showForm = ref(true);
let showErrors = ref(false);

if (user) {
    name.value = user.value?.name;
    email.value = user.value?.email;
}

function submit() {
    axios
        .post(route("earnApi.learn.waitList"), {
            name: name.value,
            email: email.value,
        })
        .then((res) => {
            if (res.status === 200) {
                showForm.value = false;
            }
        })
        .catch((error) => {
            showErrors.value = true;
        });
}
</script>

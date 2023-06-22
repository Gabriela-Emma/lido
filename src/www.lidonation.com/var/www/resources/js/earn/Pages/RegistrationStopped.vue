<template>
    <Modal :show="show">
        <div class="z-50 bg-labs-red flex flex-col">
            <header class="p-6 bg-labs-black text-white">
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
                <p class="text-xl text-white">
                    Programu ya LTE kwa sasa imefungwa kwa usajili mpya, lakini tutaifungua tena kwa watumiaji hivi karibuni. Asante kwa uelewa wako na uvumilivu.
                </p>
            </div>
            <div class="flex gap-3 text-md w-full justify-center mb-3">
                <span>Tayari una akaunti{{ $t("") }}?</span>
                <Link
                    href="/earn/learn/login"
                    class="font-bold text-teal-600 hover:text-teal-500 border-none px-2"
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
import { ref } from "vue";
import {Link} from '@inertiajs/vue3';
let show = ref(true);
</script>

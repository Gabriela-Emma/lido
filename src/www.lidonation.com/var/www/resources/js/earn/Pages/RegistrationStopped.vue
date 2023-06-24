<template>
    <Modal :show="show">
        <div class="z-50 flex flex-col bg-labs-red">
            <header class="p-6 text-white bg-labs-black">
                <h2>Usajili haufanyiki kwa sasa.</h2>
            </header>

            <div class="flex items-center gap-2 px-8 py-16 sm:px-24">
                <!-- <div
                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                >
                    <ExclamationTriangleIcon
                        class="w-6 h-6 text-red-600"
                        aria-hidden="true"
                    />
                </div> -->
                <p class="text-xl text-white">
                    Programu ya LTE kwa sasa imefungwa kwa usajili mpya, lakini tutaifungua tena kwa watumiaji hivi karibuni. Asante kwa uelewa wako na uvumilivu.
                </p>
            </div>
            <div class="flex justify-center w-full gap-3 mb-3 text-md">
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
import { ref } from "vue";
import {Link} from '@inertiajs/vue3';
let show = ref(true);
</script>

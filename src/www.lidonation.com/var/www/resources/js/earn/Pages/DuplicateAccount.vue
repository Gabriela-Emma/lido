<template>
    <Modal :show="show">
        <div class="z-50 bg-labs-red flex flex-col">
            <header class="p-6 bg-labs-black text-white">
                <h2>{{ $t('duplicateAccountTitle') }}</h2>
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
                    {{ $t('duplicateAccountMessage') }}:&nbsp; <span class="font-bold">msaada@lidonation.com</span>
                </p>
                <p class="text-xl text-white">
                    {{ $t('duplicateAccountNew') }}
                </p>
            </div>
            <div
                class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
            >
                <button
                    type="button"
                    @click.prevent="closeModal"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                >
                {{ $t('duplicateAccountClose') }}
                </button>
            </div>
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import Modal from "../../global/Shared/Components/Modal.vue";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";
import { useModal } from "momentum-modal";
import { ref } from "vue";
let show = ref(true);

const { close } = useModal();

function closeModal() {
    close();
}
</script>

<script lang="ts" setup>
import {TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle} from "@headlessui/vue";
import {useModal} from "momentum-modal";
import {XMarkIcon} from '@heroicons/vue/24/outline';
import {ref, watch} from "vue";

const {show, close, redirect} = useModal();

const props = withDefaults(
    defineProps<{
        position?: string,
        show?: boolean
    }>(),
    {
        show: true,
        position: () => {
            return 'center'
        },
    },
);

let showRef = ref(props.show);
watch(showRef, () => {
    if (!props.show) {
        close();
    }
});

</script>

<template>
    <div>
        <TransitionRoot appear :show="show" v-if="props.position === 'sidebar'">
            <Dialog as="div" class="relative z-20" @close="close">
                <div class="fixed inset-0" />

                <div class="fixed inset-0 overflow-hidden">
                    <div class="absolute inset-0 overflow-hidden bg-white/75">
                        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none sm:pl-16">
                            <TransitionChild as="template" @after-leave="redirect" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
                                <DialogPanel class="w-screen max-w-xl overflow-y-auto pointer-events-auto">
                                    <slot />
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- 'bg-white/[0.96] w-full flex just-center items-center': position === 'center' -->
        <TransitionRoot appear :show="show" v-else>>
            <Dialog as="div" class="relative z-20" @close="show = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                 enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                 leave-to="opacity-0" @after-leave="redirect">
                    <div class="fixed inset-0 hidden transition-opacity bg-gray-500 bg-opacity-75 rounded-sm md:block"/>
                </TransitionChild>

                <div class="fixed inset-0 z-20 overflow-y-auto">
                    <div
                        class="flex items-stretch justify-center min-h-full text-center md:items-center md:px-2 lg:px-4">
                        <TransitionChild as="template" enter="ease-out duration-300"
                                         enter-from="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                                         enter-to="opacity-100 translate-y-0 md:scale-100" leave="ease-in duration-200"
                                         leave-from="opacity-100 translate-y-0 md:scale-100"
                                         leave-to="opacity-0 translate-y-4 md:translate-y-0 md:scale-95">
                            <DialogPanel
                                class="flex text-base text-left transition transform wfull md:max-w-2xl lg:max-w-5xl">
                                <div
                                    class="relative flex items-center bg-white shadow-2xl wfull">
                                    <button type="button"
                                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8"
                                            @click="show = false">
                                        <span class="sr-only">{{ $t('Close') }}</span>
                                        <XMarkIcon class="w-6 h-6" aria-hidden="true"/>
                                    </button>
                                    <slot/>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

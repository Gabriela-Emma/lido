<script lang="ts" setup>
import {TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle} from "@headlessui/vue";
import {useModal} from "momentum-modal";
import {XMarkIcon} from '@heroicons/vue/24/outline';

const {show, close, redirect} = useModal();

const props = withDefaults(
    defineProps<{
        position?: string
    }>(),
    {
        position: () => {
            return 'center'
        },
    },
);

</script>

<template>
    <div>
        <TransitionRoot appear :show="show" v-if="props.position === 'sidebar'">
            <Dialog as="div" class="relative z-10" @close="close">
                <div class="fixed inset-0" />

                <div class="fixed inset-0 overflow-hidden">
                    <div class="absolute inset-0 overflow-hidden bg-white/75">
                        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                            <TransitionChild as="template" @after-leave="redirect" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
                                <DialogPanel class="pointer-events-auto w-screen max-w-xl overflow-y-auto">
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
            <Dialog as="div" class="relative z-10" @close="show = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                 enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <div class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 rounded-sm transition-opacity md:block"/>
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div
                        class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
                        <TransitionChild as="template" enter="ease-out duration-300"
                                         enter-from="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                                         enter-to="opacity-100 translate-y-0 md:scale-100" leave="ease-in duration-200"
                                         leave-from="opacity-100 translate-y-0 md:scale-100"
                                         leave-to="opacity-0 translate-y-4 md:translate-y-0 md:scale-95">
                            <DialogPanel
                                class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
                                <div
                                    class="relative flex w-full items-center overflow-hidden bg-white px-4 pt-14 pb-8 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                                    <button type="button"
                                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8"
                                            @click="open = false">
                                        <span class="sr-only">Close</span>
                                        <XMarkIcon class="h-6 w-6" aria-hidden="true"/>
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

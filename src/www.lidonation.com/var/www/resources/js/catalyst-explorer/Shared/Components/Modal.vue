<script lang="ts" setup>
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from "@headlessui/vue";
import { useModal } from "momentum-modal";
const { show, close, redirect } = useModal();
import { ref } from 'vue';

// const open = ref(true);
</script>

<template>
    <TransitionRoot appear as="template" :show="show">
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
<!--    <TransitionRoot appear as="template" :show="show">-->
<!--        <Dialog as="div" class="relative z-10" @close="close">-->
<!--            <TransitionChild-->
<!--                @after-leave="redirect"-->
<!--                as="template"-->
<!--                enter="duration-300 ease-out"-->
<!--                enter-from="opacity-0"-->
<!--                enter-to="opacity-100"-->
<!--                leave="duration-200 ease-in"-->
<!--                leave-from="opacity-100"-->
<!--                leave-to="opacity-0">-->
<!--                <div class="fixed inset-0 bg-black/75 transition-opacity" />-->
<!--            </TransitionChild>-->

<!--            <div class="fixed inset-0 overflow-y-auto">-->
<!--                <div class="flex flex-col min-h-full items-start justify-start pt-28">-->
<!--                    <TransitionChild-->
<!--                        as="template"-->
<!--                        enter="duration-300 ease-out"-->
<!--                        enter-from="opacity-0 scale-95"-->
<!--                        enter-to="opacity-100 scale-100"-->
<!--                        leave="duration-200 ease-in"-->
<!--                        leave-from="opacity-100 scale-100"-->
<!--                        leave-to="opacity-0 scale-95">-->
<!--                        <DialogPanel class="w-full flex-1 max-w-xl transform overflow-hidden rounded-r-sm bg-white text-left align-middle shadow-xl transition-all">-->
<!--                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-slate-900">-->
<!--                                <slot name="title" />-->
<!--                            </DialogTitle>-->
<!--                            <slot />-->
<!--                        </DialogPanel>-->
<!--                    </TransitionChild>-->
<!--                </div>-->
<!--            </div>-->
<!--        </Dialog>-->
<!--    </TransitionRoot>-->
</template>

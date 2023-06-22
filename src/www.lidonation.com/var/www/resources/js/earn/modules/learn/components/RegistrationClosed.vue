<template>
    <TransitionRoot as="template" :show="isOpen">
        <Dialog as="div" class="relative z-10">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                        >
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div
                                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                                    >
                                        <ExclamationTriangleIcon
                                            class="h-6 w-6 text-red-600"
                                            aria-hidden="true"
                                        />
                                    </div>
                                    <div
                                        class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left"
                                    >
                                        <DialogTitle
                                            as="h3"
                                            class="text-base font-semibold leading-6 text-gray-900"
                                            >Registration is currently unavailable.</DialogTitle>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                The LTE program is currently closed for new registrations, but we will be reopening it to users in the near future. Thank you for your understanding and patience.
                                            </p>
                                        </div>
                                        <div class="flex gap-3 text-sm w-full justify-center mt-2">
                                            <span>Already have an account{{ $t("") }}?</span>
                                            <Link href="/earn/learn/login" class="font-bold text-teal-600 hover:text-teal-500 border-none px-2"> 
                                                {{ $t("Sign in") }}
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script lang="ts" setup>
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";
import {Link} from '@inertiajs/vue3';

const props = withDefaults(
    defineProps<{
        isOpen?: boolean;
    }>(),
    {}
);
</script>

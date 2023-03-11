<template>
    <Modal >
        <div class="bg-teal-900 w-full flex flex-col rounded-sm relative overflow-clip">
            <div class="mt-8 bg-teal-700 pb-16 sm:mt-12 sm:pb-20 lg:pb-28">
                <div class="relative">
                    <div class="absolute inset-0 h-1/2 bg-teal-900"></div>
                    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="max-w-lg mx-auto rounded-sm shadow-lg overflow-hidden lg:max-w-none lg:flex">

                            <div class="flex-1 bg-teal-500">
                                <div class="flex justify-between w-full">
                                    <div class="p-4 w-1/2 text-white" >
                                    </div>
                                    <div class="bg-teal-600 ml-auto">
                                        <Login :show-logo="false" :embedded="true" :isUtility="true" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import Login from './Login.vue';
import Modal from '../../Shared/Components/Modal.vue';

</script>

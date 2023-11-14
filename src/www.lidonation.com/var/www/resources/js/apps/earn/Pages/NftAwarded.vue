<template>
    <Modal :show="show">
        <div class="relative bg-white">
            <div
                class="mx-auto max-w-7xl lg:grid lg:grid-cols-12 lg:gap-x-8 lg:px-8"
            >
                <div
                    class="px-6 sm:pb-32 lg:col-span-7 lg:px-0 lg:pb-20 lg:pt-20 xl:col-span-6"
                >
                    <div class="mx-auto max-w-2xl lg:mx-0">
                        <h1
                            class="mt-12 text-2xl font-bold tracking-tight text-gray-900 sm:mt-10"
                        >
                            You have won an nft!
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">
                            Congratulations! You have won a unique NFT
                            for successfully completing the topic in the Learn
                            to Earn program.
                        </p>
                        <p class="mt-6 text-lg leading-8 text-gray-900">Name: <span class="text-gray-600">{{ nft.name }}</span></p>
                        <p class="mt-6 text-lg leading-8 text-gray-900">Rarity: <span class="text-red-500 font-bold">{{ nft.rarity }}</span></p>
                    </div>
                </div>
                <div
                    class="relative lg:col-span-5 lg:-mr-8 xl:absolute xl:inset-0 xl:left-1/2 xl:mr-0"
                >
                    <img
                        class="aspect-[3/2] w-full bg-gray-50 object-cover lg:absolute lg:inset-0 lg:aspect-auto lg:h-full"
                        :src="nft.preview_link"
                        alt=""
                    />
                </div>
            </div>
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import Modal from "@/global/Components/Modal.vue";
import { ref } from "vue";
const props = withDefaults(
    defineProps<{
        nft?: any;
    }>(),
    {}
);
let show = ref(true);
</script>

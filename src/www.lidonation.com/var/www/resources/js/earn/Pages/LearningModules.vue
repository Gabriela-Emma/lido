<template>
    <section class="py-4 sm:py-4 md:pb-20 md:pt-8 pb-16 xl:pb-36 xl:pt-16 bg-opacity-5 text-white overflow-visible z-5"
             style="background: url('/img/ngong-road-learn.svg')  0% 25% / 100%; background-size: 100% auto;">
        <div class="container">
            <div class="text-center flex flex-col gap-1 sm:gap-2 xl:gap-4">
                <div class="text-xl sm:text-2xl md:text-4xl xl:text-6xl font-bold">
                    {{ $t("Learn2earn") }}
                </div>
                <div class="text-sm sm:text-md md:text-lg xl:text-xl flex gap-2 justify-center">
                    <span class="after:content-['.'] after:text-2xl">
                        {{ $t("Learn") }}
                    </span>
                    <span class="after:content-['.'] after:text-2xl">
                        {{ $t("Take a Quiz") }}
                    </span>
                    <span class="after:content-['.'] after:text-2xl">
                        {{ $t("Earn") }}
                    </span>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-white">
        <div class="container text-xl xl:text-2xl">
            <header class="py-8">
                <h2 class="text-center font-semibold text-labs-black text-xl md:text-2xl lg:text-3xl xl:text-4xl 2xl:text-5xl">
                    Available Modules
                </h2>
            </header>
            <LearningModuleCard v-for="module in learningModules" :key="module.id" :learning-module="module" />
        </div>
    </section>
</template>

<script lang="ts" setup>
import {inject, ref} from "vue";
import {Link} from '@inertiajs/vue3';
import LearningModuleData = App.DataTransferObjects.LearningModuleData;
import LearningModuleCard from "../modules/earn/components/LearningModuleCard.vue";

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        currPage?: number,
        perPage?: number,
        locale: string,
        modules: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: LearningModuleData[]
        };
    }>(), {});

let learningModules = ref<LearningModuleData[]>(props.modules.data);
</script>
<style scoped>

</style>

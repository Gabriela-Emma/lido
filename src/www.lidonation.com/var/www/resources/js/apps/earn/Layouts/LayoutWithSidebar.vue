<template>
    <header v-if="user">
        <LearnNav :crumbs=crumbs />
    </header>

    <section class="py-4 sm:py-4 md:pb-20 md:pt-8 pb-16 xl:pb-24 xl:pt-16 bg-opacity-5 text-white overflow-visible z-5"
             style="background: url('/img/ngong-road-learn.svg') 0% 35% / 100%; background-size: 100% auto;">
        <div class="container">
            <div class="text-center flex flex-col gap-1 sm:gap-2 xl:gap-3">
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

    <section class="py-8">
        <div class="container">
            <div class="grid grid-cols-7 gap-8">
                <div class="col-span-7 relative md:col-span-4 xl:col-span-5 border-8 border-labs-red py-8 px-4 rounded-sm min-h-full">
                    <slot></slot>
                    <Spinner />
                </div>

                <aside class="col-span-7 md:col-span-3 xl:col-span-2">
                    <Sidebar />
                </aside>
            </div>
        </div>
    </section>
    <footer>
        <Modal/>
    </footer>
</template>

<script lang="ts" setup>
import {Modal} from "momentum-modal"
import Sidebar from "../modules/learn/components/Sidebar.vue";
import {usePage} from '@inertiajs/vue3';
import {computed} from "vue";
import User from '@/global/models/user';
import Spinner from "@/global/Components/Spinner.vue";
import LearnNav from '../modules/learn/components/LearnNav.vue'

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});

const user = computed(() => usePage().props.ziggy.user as User);
</script>

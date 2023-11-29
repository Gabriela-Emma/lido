<template>
    <div ref="target">
        <ul>
            <li class="flow-root menu-item">
                <a @click="openMenu = !openMenu"
                   class="px-1 py-3 font-semibold text-white menu-link hover:text-teal-500" href="#">
                    More
                    <ChevronDownIcon class="inline-block w-5 h-5"/>
                </a>
            </li>
        </ul>
        <teleport to="header">
            <transition enter-from-class="opacity-0 scale-95">
                <div v-show="openMenu"
                     class="fixed left-1/2 -translate-x-1/2 w-[1250px] h-[200px] mt-12 font-semibold rounded-sm p-6 shadow-md bg-white">
                    <ul class="flex flex-row gap-28 text-lg">
                        <li v-for="heading in menudrops" :key="heading.title">
                            <span class="text-slate-700 text-xl">
                                {{heading.title}}
                            </span>
                            <ul class="flex flex-col gap-1">
                                <li v-for="link in heading.links" :key="link.name">
                                    <div v-if="link.route">
                                        <Link
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :class="{ 'text-teal-600': $page.component.startsWith(link.component) }"
                                        :href="route(link.route)">
                                        {{ $t(link.name) }}
                                        </Link>
                                    </div>
                                    <div v-else>
                                        <a 
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :href=link.url>
                                        <span class="inline-block">{{ link.name }}</span>
                                        </a>
                                    </div>                                    
                                </li>
                            </ul> 
                        </li>
                    </ul>
                </div>
            </transition>
        </teleport>
    </div>
</template>
<script lang="ts" setup>
import {inject, ref} from "vue";
import route from "ziggy-js";
import {Link} from '@inertiajs/vue3';
import {onClickOutside} from '@vueuse/core';
import {ChevronDownIcon} from "@heroicons/vue/20/solid";
import { menulinkStore } from '../../stores/menu-links-store';

const { menudrops } = menulinkStore();

const $utils: any = inject('$utils');

let openMenu = ref(false);

const target = ref(null)

onClickOutside(target, (event: any) => openMenu.value = false)

</script>

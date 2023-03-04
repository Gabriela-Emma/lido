<template>
    <header-component titleName0="My Catalyst" titleName1="Groups" subTitle=""/>

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="py-6 px-2 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav/>
                </aside>

                <div class="space-y-6 sm:px-6 lg:col-span-9 xl:col-span-10">
                    <div class="bg-white flex justify-between items-center p-4 rounded-sm">
                        <div class="">
                            <h2 class="leading-6 text-slate-900">My Groups</h2>
                        </div>
                        <div class="w-80">
                            <Multiselect
                                class="block mt-3 rounded-sm z-10 border border-slate-300 p-0.5 font-medium text-slate-900"
                                v-model="selectedGroup"
                                :options="groupOptions"

                                :disabled="groupOptions?.length === 0"
                                :close-on-select="true"
                                :clear-on-select="false"
                                :multiple="false"
                                :taggable="false"
                                :hide-selected="true"
                                :placeholder="groupOptions?.length === 0 ? 'Create a group or company below' : 'Select group to manage'"
                                label="name"
                            />
                        </div>
                    </div>
                    <div>
                        <div class="flex flex-col gap-8">
                            <TransitionGroup v-for="(group, index) in groups" :key="index"  tag="ul" name="fade" class="container flex flex-col gap-8" preserve-scroll>
                                <UserGroupCard v-if="selectedGroup === group.name||('id' in group )=== false" :group="group" @groupCreated="selectedGroup = group.name" />
                            </TransitionGroup>

                            <div class="text-center rounded-sm border border-slate-400 border-dashed p-8">
                                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="2"
                                          d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-slate-900">
                                    Add a Group
                                </h3>
                                <p class="mt-1 text-md text-slate-500">
                                    Is this project part of a team or company,
                                    create a profile to feature on the groups page.
                                </p>
                                <div class="mt-6">
                                    <button type="button" @click="newGroup"
                                            class="inline-flex items-center rounded-sm border border-transparent bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                        <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true"/>
                                        Add new Group or Company
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import UserNav from "./UserNav.vue";
import UserGroupCard from "./UserGroupCard.vue";
import Group from "../../models/group";
import {PlusIcon} from '@heroicons/vue/20/solid';
import {ref, Ref, computed} from "vue";
import Profile from "../../models/profile";
import Multiselect from '@vueform/multiselect';
import {reactive} from "@vue/reactivity";


let newGroups = [];
const props = withDefaults(
    defineProps<{
        locale: string,
        profiles: Profile[],
        groups: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Group[]
        };
        groupOptions?:string[]
    }>(), {});

const selectedGroup = ref(props.groupOptions?.[0] || '');

const owner: Profile = props.profiles.length > 0 ? props.profiles[0] : null;
const groups: Ref<Group[]> = ref([...props.groups?.data] || []);


function newGroup() {
    const group = {
        bio: null,
        name: null,
        website: null,
        github: null,
        owner
    } as Group;
    groups.value.push(group);
}

</script>
<style>
.container {
    position: relative;
    padding: 0;
}

.item {
    width: 100%;
    height: 30px;
    background-color: #f3f3f3;
    border: 1px solid #666;
    box-sizing: border-box;
}

/* 1. declare transition */
.fade-move,
.fade-enter-active,
.fade-leave-active {
    transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1);
}

/* 2. declare enter from and leave to state */
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scaleY(0.01) translate(30px, 0);
}

/* 3. ensure leaving items are taken out of layout flow so that moving
      animations can be calculated correctly. */
.fade-leave-active {
    position: absolute;
}
</style>

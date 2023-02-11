<template>
    <header-component titleName0="My Catalyst" titleName1="Proposals" subTitle=""/>

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="py-6 px-2 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav/>
                </aside>

                <div class="space-y-6 sm:px-6 lg:col-span-9 xl:col-span-10 bg-white p-6">
                    <div class="">
                        <div>
                            <h2 class="leading-6 text-slate-900">My Proposals</h2>
                        </div>
                        <div>
                            <p>Coming soon</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import UserNav from "./UserNav.vue";

</script>

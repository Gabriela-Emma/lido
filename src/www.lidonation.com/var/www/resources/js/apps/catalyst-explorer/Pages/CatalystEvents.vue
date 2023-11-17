<template>
    <Head title="Catalyst Event" />
    <header-component
        titleName0="catalyst"
        titleName1="events"
        subTitle="Check out catalyst events and register to host some"
    />
    <main class="bg-primary-20">
        <section class="py-8 container">
            <div
                class="text-center items-center bg-white w-full px-6 py-2.5"
            >
                <p class="text-md">
                    <a href="#form" class="text-black">
                        <strong class="font-semibold">Catalyst SWARM</strong>
                        <svg
                            viewBox="0 0 2 2"
                            class="mx-2 inline h-0.5 w-0.5 fill-current"
                            aria-hidden="true"
                        >
                            <circle cx="1" cy="1" r="1" /></svg>
                        Register to host After Town Hall Breakout Room &
                        Community Events&nbsp;<span aria-hidden="true"
                            >&rarr;</span
                        >
                    </a>
                </p>
            </div>
        </section>
        <section class="container pb-8" id="form">
            <EventForm />
        </section>
    </main>
</template>

<script lang="ts" setup>
import EventForm from "../modules/eventsModule/EventForm.vue"
import {Head} from "@inertiajs/vue3";
</script>

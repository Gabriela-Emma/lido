<template>
    <Nav :crumbs=crumbs />

    <section class="">
        <slot></slot>
        <Modal />
    </section>
</template>

<script lang="ts" setup>
import { Modal } from "momentum-modal"
import Nav from "./Nav.vue";

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});
</script>

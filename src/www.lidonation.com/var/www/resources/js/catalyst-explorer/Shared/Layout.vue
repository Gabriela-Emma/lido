<template>
    <Nav :crumbs=crumbs />

    <section class="">
        <slot></slot>
        <Modal />
        <Spinner />
    </section>
</template>

<script lang="ts" setup>
import { Modal } from "momentum-modal"
import Nav from "./Nav.vue";
import Spinner from "../../global/Shared/Components/Spinner.vue";

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});
</script>

<template>
    <Nav :crumbs="crumbs" />
    <slot></slot>
    <div class="z-40">
        <Modal />
    </div>
</template>
<script lang="ts" setup>
import Nav from "@apps/catalyst-explorer/Components/Global/Nav.vue";
import { Modal } from "momentum-modal";

withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});
</script>

<template>
    <Nav :crumbs="crumbs" />
    <slot></slot>
</template>
<script lang="ts" setup>
import Nav from "@apps/catalyst-explorer/Components/Global/Nav.vue";

withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});
</script>

<template>
        <div class="sticky top-0 z-30 flex flex-col">
            <Nav :crumbs=crumbs />
            <GlobalPlayer />
        </div>

    <slot></slot>
    <div class="z-40">
        <Modal />
    </div>
</template>
<script lang="ts" setup>
import Nav from "@apps/catalyst-explorer/Components/Global/Nav.vue";
import { Modal } from "momentum-modal";
import GlobalPlayer from "@/global/Components/GlobalPlayer.vue";

withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});
</script>

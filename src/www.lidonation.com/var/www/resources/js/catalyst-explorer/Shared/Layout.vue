<template>
    <div class="sticky flex flex-col">
        <Nav :crumbs=crumbs />
        <GlobalPlayer />
    </div>

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
import GlobalPlayer from "../../global/Shared/Components/GlobalPlayer.vue";

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});
</script>

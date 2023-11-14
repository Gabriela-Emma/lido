<template>
    <div>
        <Nav :crumbs="[]" />
    </div>

    <section class="">
        <slot></slot>

        <Modal />
    </section>
</template>

<script lang="ts" setup>
import { Modal } from "momentum-modal"
import Nav from "@apps/delegators/Components/Global/Nav.vue";

</script>

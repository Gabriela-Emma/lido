<template>
    <Nav :crumbs=crumbs />

    <section class="container">
        <slot></slot>
    </section>
</template>

<script lang="ts">

import Nav from "./Nav.vue";

export default {
    components: { Nav },

    props: { crumbs: Array}
}
</script>

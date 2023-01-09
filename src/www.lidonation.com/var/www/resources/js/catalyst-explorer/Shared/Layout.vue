<template>
    <Nav :crumbs=crumbs />
    <slot></slot>
</template>

<script>
import Nav from "./Nav.vue";

export default {
    components: { Nav },

    props: { crumbs: Array}
}
</script>
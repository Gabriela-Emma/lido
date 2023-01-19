<template>
    <Link class="px-1 py-3 text-white menu-link hover:text-yellow-500"
        :class="{ 'text-yellow-500': active }">
        <slot></slot>
    </Link>
</template>

<script lang="ts">
import { Link } from '@inertiajs/vue3';

export default {
    components : { Link },

    props: {
        active: Boolean
    }
};
</script>

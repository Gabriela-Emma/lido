<template>
    <div>
        <slot></slot>
    </div>
</template>
<script lang="ts" setup>
import User from "@/global/models/user";

withDefaults(
    defineProps<{
        user: User
    }>(), {});
</script>

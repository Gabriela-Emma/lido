<template>
    <ul role="list"
        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 gap-3 max-w-7xl 2xl:max-w-full mx-auto">
      <GroupCard v-for="group in groups" :catalystGroup="group"></GroupCard>             
    </ul>
</template>

<script lang="ts" setup>
import Group from '../../models/group';
import GroupCard from './GroupCard.vue';

const props=withDefaults(
    defineProps<{
        groups:Group[];
    }>(),
    {
        groups:() => []
    }
)

</script>
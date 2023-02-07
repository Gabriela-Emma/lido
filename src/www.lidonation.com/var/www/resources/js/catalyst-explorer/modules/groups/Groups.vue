<template>
    <ul role="list"
        class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-8">
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
<template>
    <div class="text-center">
        <ul role="list"
            class="grid grid-cols-2 mx-auto gap-4 sm:grid-cols-4 xl:grid-cols-5 3xl:grid-cols-6">
            <PersonCard v-for="user in users" :user="user"></PersonCard>
        </ul>
    </div>
</template>

<script lang="ts" setup>
import User from "../../../global/Shared/Models/user";
import PersonCard from "./PersonCard.vue";

const props = withDefaults(
    defineProps<{
        users: User[]
    }>(),
    {
        users: () => [],
    },
);

</script>

<template>
    <section class="relative py-8 mb-8" aria-labelledby="quick-links-title">
        <div class="container">
            <div class="text-center">
                <ul role="list"
                    class="grid grid-cols-2 mx-auto gap-4 sm:grid-cols-4 xl:grid-cols-5 3xl:grid-cols-6">
                    <PersonCard v-for="user in users" :user="user"> </PersonCard>
                </ul>
            </div>
        </div>
    </section>
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

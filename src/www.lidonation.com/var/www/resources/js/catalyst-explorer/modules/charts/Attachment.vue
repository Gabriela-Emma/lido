<template>
    <div v-if="attachementLink" class="flex items-center gap-2">
        <a :href="props.attachementLink"
            type="button"
            class="px-2 py-1 text-xs font-semibold text-gray-900 bg-white rounded-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
            Download raw snapshot
        </a>
    </div>
</template>

<script lang="ts" setup>

const props = withDefaults(
    defineProps<{
        attachementLink?: string
    }>(),
    {},
);

</script>

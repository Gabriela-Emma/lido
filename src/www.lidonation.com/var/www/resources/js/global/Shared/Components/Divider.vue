<template>
    <div class="relative my-3">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-white px-2 text-gray-500">
                <PlusIcon class="h-5 w-5" aria="true" />
            </span>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { PlusIcon } from '@heroicons/vue/20/solid';

</script>
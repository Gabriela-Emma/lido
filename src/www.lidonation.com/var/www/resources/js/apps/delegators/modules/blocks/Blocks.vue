<template>
     <div
        class="w-full p-8 rounded-sm bg-gradient-to-br from-primary-10 to-primary-20 via-slate-50 2xl:col-span-3">
        <div class="relative">
            <div class="sm:flex sm:items-start">
                <div class="text-lg sm:flex-auto">
                    <h1 class="flex flex-row items-end gap-2 text-2xl font-semibold xl:text-4xl 2xl:text-6xl text-slate-900">
                        <span>Blocks</span>
                    </h1>
                    <PoolDetails />
                    <p class="mt-8 text-xl text-slate-700 xl:text-2xl">
                        Recent blocks & upcoming assignments
                    </p>
                </div>
            </div>
            <div class="flex flex-col mt-4">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8 max-h-[28rem] overflow-y-auto min-h-[32rem]">
                        <BlocksTable />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import BlocksTable from './BlocksTable.vue';
import PoolDetails from './PoolDetalts.vue';

</script>

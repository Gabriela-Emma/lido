<template>
    <div class="gap-6 md:grid md:grid-cols-2 2xl:grid-cols-5 animate-pulse lido-origin">
        <div class="flex flex-col w-full gap-4 p-8 rounded-sm sm:gap-8 2xl:col-span-3">
            <div class="w-2/3 h-12 pr-4 rounded bg-primary-50"></div>
            <div class="flex flex-col w-full gap-2 sm:gap-4">
                <div v-for="index in 6" class="w-full h-4 rounded bg-primary-50"></div>
            </div>
            <div class="w-2/3 h-8 pr-4 rounded bg-primary-50"></div>
        </div>
        <div class="w-full p-2 rounded-sm md:p-8 2xl:col-span-2 bg-primary-40">
            <div class="flex flex-row flex-wrap justify-around">
                <div class="p-2" v-for="index in 6">
                    <div class="flex justify-center w-32 h-32 rounded-full bg-primary-50"></div>
                </div>
            </div>
        </div>
    </div>
</template>

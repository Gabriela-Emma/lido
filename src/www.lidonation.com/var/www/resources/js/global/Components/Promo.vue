<template>
    <div class="px-0 bg-slate-800 min-h-[8rem]">
        <div v-if="promo">
            <div class="relative rounded-sm">
                <a :href="promo?.uri" target="_blank" :title="promo?.content" class="block">
                    <img :src="promo?.feature_url" :alt="`${promo?.title}'s promo`" :title="promo?.content">
                </a>
            </div>
            <p class="mx-auto my-2 text-xs text-center text-slate-100">
                Put your ad here:
                <a title="Lido Advertisement NFTs" class="text-labs-red-light" :href="route('lido-minute-nft')">Lido Ad NFT</a>
            </p>
        </div>
</div>
</template>

<script lang="ts" setup>
import axios from 'axios';
import { inject, ref, Ref } from 'vue';
import PromoData = App.DataTransferObjects.PromoData;
import route from 'ziggy-js';
const $utils: any = inject('$utils');



const emit = defineEmits<{
    (e: 'promoData',promoData ): void,

}>();


let promo: Ref<PromoData> = ref(null)
axios.get(route('promos.view'))
    .then((res) => {
        promo.value = res.data;
        emit('promoData',promo.value)
    })

const props = withDefaults(
    defineProps<{
        customise: boolean
        backgroundColor:string
    }>(),
    {
        customise: false,
        backgroundColor: 'bg-slate-800',
    });


</script>

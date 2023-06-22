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
                <a title="Lido Advertisement NFTs" class="text-labs-red-light" :href="$utils.localizeRoute('lido-minute-nft')">Lido Ad NFT</a>
            </p>
        </div>
</div>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import {inject,ref,Ref} from 'vue';
import PromoData =App.DataTransferObjects.PromoData
const $utils: any = inject('$utils');

let promo:Ref<PromoData> = ref(null)
axios.get(`${usePage().props.base_url}/api/promos/`)
.then((res) =>{
    promo.value = res.data;
})


</script>

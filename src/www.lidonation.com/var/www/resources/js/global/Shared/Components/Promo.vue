<template>
    <div class="px-8 bg-teal-600 xl:px-8 2xl:px-16">
        <div class="px-4 py-4 mb-8 rounded-sm xl:px-8 2xl:px-16">
            <div class="relative rounded-sm">
                <div :href="promo?.uri" target="_blank">
                    <a :href="promo?.uri" target="_blank" :title="promo?.content">
                        <img :src="promo?.feature_url" :alt="`${promo?.title}'s promo`" :title="promo?.content">
                    </a>
                </div>
            </div>
        </div>
        <p class="mx-auto mb-1 text-xs text-center ">
            Put your ad here:
            <a title="Lido Advertisement NFTs" class="text-labs-red-light" :href="$utils.localizeRoute('lido-minute-nft')">Lido Ad NFT</a>
        </p>
    </div>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import {inject} from 'vue';
import PromoData =App.DataTransferObjects.PromoData
const $utils: any = inject('$utils');


let promo:PromoData
axios.get(`${usePage().props.base_url}/api/promos/`)
.then((res) =>{
    promo = res.data;
})


</script>
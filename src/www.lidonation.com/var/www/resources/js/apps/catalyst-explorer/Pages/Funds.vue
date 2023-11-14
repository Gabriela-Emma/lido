<template>
    <header-component titleName0="catalyst" titleName1="Funding Rounds" subTitle=""/>
    <FundsList :funds="funds"></FundsList>
</template>

<script lang="ts">
import {storeToRefs} from "pinia";
import {useFundsStore} from "@apps/catalyst-explorer/stores/funds-store";
import FundsList from "@apps/catalyst-explorer/modules/funds/FundsList.vue";
import HeaderComponent from "@apps/catalyst-explorer/Components/Global/HeaderComponent.vue";

export default {
    setup() {
        const {funds} = storeToRefs(useFundsStore())

        return {
            funds
        }
    },
    components: {
        HeaderComponent,
        FundsList
    }
}
</script>



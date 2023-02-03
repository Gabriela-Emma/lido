<template>
    <header-component titleName0="Catalyst" titleName1="Funding Rounds" subTitle=""/>
    <Funds :funds="funds"></Funds>
</template>

<script lang="ts">
import { storeToRefs } from "pinia";
import {useFundsStore} from "../stores/funds-store"
import Funds from  "../modules/funds/Funds.vue"
import Fund from "../models/fund";
export default {
  setup() {
    const { funds } = storeToRefs(useFundsStore());

    const fundsArray: Fund[] = funds.value;

    return {
      funds: fundsArray
    };
  }
}
</script>

<template>
  <header-component titleName0="Catalyst" titleName1="Funding Rounds" subTitle=""/>
  <Funds :funds="funds"></Funds>
</template>

<script lang="ts">
import { storeToRefs } from "pinia";
import {useFundsStore} from "../stores/funds-store"
import Funds from  "../modules/funds/Funds.vue"


export default {
  setup(){
      const {funds}=storeToRefs(useFundsStore())

      return{
          funds
      }
  },
  components:{
    Funds
  }
}
</script>



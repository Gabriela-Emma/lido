import {defineStore} from "pinia";
import {computed, onMounted, ref} from "vue";
import Fund from "../models/fund";
import {AxiosError} from "axios";
import route from "ziggy-js";

export const useFundsStore = defineStore('funds', () => {
    let funds = ref<Fund[]>([]);

    async function load() {
        // try loading from sessionStore;
        // const piniaState = sessionStorage.getItem("piniaState");
        // if (piniaState) {
            // const state = JSON.parse(piniaState);
            //     if (state.funds && state.funds.length > 0) {
            //     funds.value = state.funds;
            //     return;
            //     }
        // }

        // if (funds?.value?.length > 0) {
        //     return;
        // }

        // fetch from api
        try {
            const {data} = await window.axios.get(route('catalystExplorerApi.funds'));
            funds.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    // onMounted(load);

    return {
        funds,
        load
    };
});

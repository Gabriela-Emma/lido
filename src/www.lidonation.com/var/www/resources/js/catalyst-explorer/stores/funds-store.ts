import {defineStore} from "pinia";
import {computed, ref} from "vue";
import Fund from "../models/fund";
import {AxiosError} from "axios";

export const useFundsStore = defineStore('funds', () => {
    let funds = ref<Fund[]>([]);

    async function loadFunds() {
        if (funds?.value?.length > 0) {
            return;
        }

        try {
            const res = await window.axios.get(`/api/catalyst-explorer/funds`);
            console.log('funds::', res?.data?.data);
            this.funds = res?.data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
        // if funds already loaded
        // return
        console.log(window.axios);
    }

    return {
        funds,
        loadFunds,
    };
});

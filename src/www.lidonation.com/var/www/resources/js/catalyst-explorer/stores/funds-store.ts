import {defineStore} from "pinia";
import {computed, onMounted, ref} from "vue";
import Fund from "../models/fund";
import {AxiosError} from "axios";

export const useFundsStore = defineStore('funds', () => {
    let funds = ref<Fund[]>([]);

    async function loadFunds() {
        // try loading from sessionStore;

        if (funds?.value?.length > 0) {
            return;
        }

        // fetch from api
        try {
            const {data} = await window.axios.get(`/api/catalyst-explorer/funds`);
            funds.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    onMounted(loadFunds);

    return {
        funds
    };
});

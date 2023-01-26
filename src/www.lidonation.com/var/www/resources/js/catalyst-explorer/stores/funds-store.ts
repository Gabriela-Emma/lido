import {defineStore} from "pinia";
import {computed, ref} from "vue";
import Fund from "../models/fund";
import {AxiosError} from "axios";

export const useFundsStore = defineStore('funds', () => {
    let funds = ref<Fund[]>([]);

    if (funds?.value?.length <= 0) {
        window.axios.get(`/api/catalyst-explorer/funds`)
            .then(({data}) => {
                console.log('funds::', data?.data);
                funds = data?.data;
            }).catch((e: AxiosError | any) => {
            console.log({e});
        });
    }

    async function loadFunds() {

        // if funds already loaded
        // return
        console.log(window.axios);
    }

    return {
        funds
    };
});

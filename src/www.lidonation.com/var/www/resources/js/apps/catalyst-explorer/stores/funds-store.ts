import {defineStore} from "pinia";
import {onMounted, ref} from "vue";
import {AxiosError} from "axios";
import route from "ziggy-js";
import Fund from "@apps/catalyst-explorer/models/fund";
import axios from "../../../global/utils/axios";

export const useFundsStore = defineStore('funds', () => {
    let funds = ref<Fund[]>([]);

    async function load() {
        try {
            const {data} = await axios.get(route('catalystExplorerApi.funds'));
            funds.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    onMounted(load);

    return {
        funds,
        load
    };
});

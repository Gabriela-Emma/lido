import { defineStore, storeToRefs } from "pinia";
import { onMounted, ref, watch } from "vue";
import { AxiosError } from "axios";
import route from "ziggy-js";
import Fund from "@apps/catalyst-explorer/models/fund";
import axios from "../../../global/utils/axios";
import { useFiltersStore } from "@/global/stores/filters-stores";

export const useFundsStore = defineStore('funds', () => {
    let funds = ref<Fund[]>([]);
    const filterStore = useFiltersStore();
    const { currentModel } = storeToRefs(filterStore);
    async function load() {
        try {
            const { data } = await axios.get(route('catalystExplorerApi.funds'));
            funds.value = data?.data;
            setCounts();
        } catch (e: AxiosError | any) {
            console.log({ e });
        }
    }
    function setCounts() {
        let fundCounts = currentModel.value.props.filterCounts['fundsCount'];

        funds.value.map(fund => {
            const title = fund.title;
            if (fundCounts[title]) {
                fund['count'] = fundCounts[title];
            } else {
                fund['count'] = 0;
            }
            return fund;
        });
    }

    watch([() => currentModel.value], () => {
        setCounts()
    }, { immediate: true, deep: true });
    onMounted(load);

    return {
        funds,
        load
    };
});

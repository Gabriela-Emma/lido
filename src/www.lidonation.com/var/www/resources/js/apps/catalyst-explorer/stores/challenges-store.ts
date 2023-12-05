import {defineStore, storeToRefs} from "pinia";
import Fund from "../models/fund";
import {AxiosError} from "axios";
import {computed, onMounted, Ref, ref, watch} from "vue";
import ChallengeFilters from "../models/challenge-filters";
import Challenge from "../models/challenge";
import {filter, some} from "lodash";
import { useFiltersStore } from "@/global/stores/filters-stores";

export const useChallengesStore = defineStore('challenges', () => {
    let filters: Ref<ChallengeFilters> = ref();
    let challenges = ref<Challenge[]>([]);
    let allChallenges = ref<Challenge[]>([]);
    const filterStore = useFiltersStore();
    const {currentModel} = storeToRefs(filterStore);

    let filteredChallenges = computed((): Challenge[] => search(filters.value));

    function search(filters: ChallengeFilters): Challenge[] {

        let results = challenges.value;

        if (filters?.funds?.length > 0) {
            results = [
                ...filter(
                    results,
                    (c) => filters?.funds.includes(c.fundId)
                )
            ]
        }
        return results;
    }

    function filterChallenges(f: ChallengeFilters) {
        filters.value = f;
    }


    async function load(fund?: Fund) {
        // try loading from sessionStore;
        if (challenges?.value?.length > 0) {
            return search(currentModel.value.filters);
        }

        // fetch from api
        try {
            const {data} = await window.axios.get(`/api/catalyst-explorer/challenges`);
            allChallenges.value = data?.data
            challenges.value = allChallenges.value;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    watch(currentModel.value.filters, () => {
        if (currentModel.value.filters.funds.length) {
            challenges.value = allChallenges.value;
            challenges.value = search(currentModel.value.filters);
        }else{
            challenges.value = allChallenges.value;
        }
    });
    onMounted(load);

    return {
        filterChallenges,
        filteredChallenges,
        challenges,
        search,
        load
    };
});

import {defineStore} from "pinia";
import Fund from "../models/fund";
import {AxiosError} from "axios";
import {computed, onMounted, Ref, ref} from "vue";
import ChallengeFilters from "../models/challenge-filters";
import Challenge from "../models/challenge";
import {filter, some} from "lodash";

export const useChallengesStore = defineStore('challenges', () => {
    let filters: Ref<ChallengeFilters> = ref();
    let challenges = ref<Challenge[]>([]);

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
            return;
        }

        // fetch from api
        try {
            const {data} = await window.axios.get(`/api/catalyst-explorer/challenges`);
            challenges.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    onMounted(load);

    return {
        filterChallenges,
        filteredChallenges,
        challenges,
        search,
        load
    };
});

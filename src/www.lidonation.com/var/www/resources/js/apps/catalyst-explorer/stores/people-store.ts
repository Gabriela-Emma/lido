import {defineStore} from "pinia";
import {AxiosError} from "axios";
import {Ref, computed, ref} from "vue";
import PeopleFilters from "../models/people-filters";
import Profile from "../models/profile";
import Proposal from "../models/proposal";
import { useFiltersStore } from "@/global/stores/filters-stores";

export const usePeopleStore = defineStore('people', () => {
    let filters: Ref<PeopleFilters> = ref();
    let people = ref<Profile[]>([]);
    let selected = ref<number[]>([]);


    async function search(f: PeopleFilters) {
        filters.value = f;
        try {
            const {data} = await window.axios.get(
                `/api/catalyst-explorer/people`,
                {
                    params: {
                        search: filters.value
                    }
                }
            );
            people.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    async function load(pp?: number[]) {

        if (people.value.length>0){return}
        try {
            const {data} = await window.axios.get(
                `/api/catalyst-explorer/people`,
                {
                    params: {
                        ids: pp.join(',')
                    }
                }
            );
            people.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    async function select(pp: number[]) {
        selected.value = [...pp];
    }

    return {
        search,
        select,
        load,
        selectedPeople: selected,
        filters,
        people
    };
});

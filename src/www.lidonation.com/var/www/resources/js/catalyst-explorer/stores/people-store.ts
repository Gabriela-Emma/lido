import {defineStore} from "pinia";
import {AxiosError} from "axios";
import {Ref, ref} from "vue";
import PeopleFilters from "../models/people-filters";
import Profile from "../models/profile";

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
                        search: filters.value.search
                    }
                }
            );
            people.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    async function load(pp: number[]) {
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

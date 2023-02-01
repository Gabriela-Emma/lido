import {defineStore} from "pinia";
import {AxiosError} from "axios";
import {Ref, ref} from "vue";
import Person from "../models/tag";
import PeopleFilters from "../models/people-filters";

export const usePeopleStore = defineStore('people', () => {
    let filters: Ref<PeopleFilters> = ref();
    let people = ref<Person[]>([]);

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
    async function loadPeople(pp: number[]) {
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

    return {
        search,
        loadPeople,
        filters,
        people
    };
});

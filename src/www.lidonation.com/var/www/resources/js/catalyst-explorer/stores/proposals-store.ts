import { AxiosError } from "axios";
import {defineStore} from "pinia";
import {Ref, ref} from "vue";
import Pagination from "../models/pagination";
import Proposal from "../models/proposal";
import ProposalFilters from "../models/proposall-filters";

export const proposalsStore = defineStore('proposals', () => {
    const pagination = ref({

    } as Pagination);
    const name = ref('Eduardo');
    const filters = ref('Eduardo');

    function search() {
        console.log(window.axios);
    }

    return {
        pagination,
        name,
        filters,
        search
    };
});
export const useProposalsStore = defineStore('proposal', () => {
    let filters: Ref<ProposalFilters> = ref();
    let proposals = ref<Proposal[]>([]);

    async function search(f: ProposalFilters) {
        filters.value = f;
        try {
            const {data} = await window.axios.get(
                `/api/catalyst-explorer/proposals`,
                {
                    params: {
                        search: filters.value.search
                    }
                }
            );
            proposals.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }
    async function loadProposals(pp: number[]) {
        try {
            const {data} = await window.axios.get(
                `/api/catalyst-explorer/proposals`,
                {
                    params: {
                        ids: pp.join(',')
                    }
                }
            );
            proposals.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    return {
        search,
        loadProposals,
        filters,
        proposals
    };
});


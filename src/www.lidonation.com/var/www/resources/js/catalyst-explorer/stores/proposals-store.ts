import { AxiosError } from "axios";
import {defineStore} from "pinia";
import {Ref, onMounted, ref} from "vue";
import Proposal from "../models/proposal";
import ProposalFilters from "../models/proposall-filters";

export const useProposalsStore = defineStore('proposals', () => {
    let filters: Ref<ProposalFilters> = ref();
    let proposals = ref<Proposal[]>([]);
    let viewType = ref('card');

    function setViewType(type?: string) {
        if (!type) {
            const urlParams = new URLSearchParams(window.location.search);
            if ( urlParams.has('qp') ) {
                viewType.value = 'quickpitch';
            } else {
                viewType.value = 'card';
            }
            return;
        }
        viewType.value = type;
    }

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

    onMounted(setViewType);

    return {
        search,
        loadProposals,
        setViewType,
        filters,
        viewType,
        proposals
    };
});


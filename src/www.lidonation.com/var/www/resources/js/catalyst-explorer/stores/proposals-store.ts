import { AxiosError } from "axios";
import {defineStore, storeToRefs} from "pinia";
import { Ref, onMounted, ref, watch } from "vue";
import Proposal from "../models/proposal";
import ProposalFilters from "../models/proposal-filters";
import { VARIABLES } from "../models/variables";
import { useFiltersStore } from "../../global/Shared/store/filters-stores";


export const useProposalsStore = defineStore('proposals', () => {
    let filters: Ref<ProposalFilters> = ref();
    let proposals = ref<Proposal[]>([]);
    let viewType = ref('card');

    function setViewType(type?: string) {
        if (!type) {
            const urlParams = new URLSearchParams(window.location.search);
            if ( urlParams.has(VARIABLES.QUICKPITCHES) ) {
                viewType.value = 'quickpitch';
            } else if ( urlParams.has(VARIABLES.RANKED_VIEW) ) {
                viewType.value = 'ranked';
            } else if( urlParams.has(VARIABLES.CARD_VIEW) ) {
                viewType.value = 'card';
            } else {
                viewType.value = getRandomElementFromArray(viewTypes);
            }
            return;
        }
        viewType.value = type;
    }

    const viewTypes = ['card', 'ranked'];

    function getRandomElementFromArray(array) {
    return array[Math.floor(Math.random() * array.length)];
    }

    async function search(f: ProposalFilters) {
        filters.value = f;
        try {
            const {data} = await window.axios.get(
                `/api/catalyst-explorer/proposals`,
                {
                    params: {
                        search: filters.value
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

    const filterStore = useFiltersStore();
    const {currentModel, canFetch} = storeToRefs(filterStore)
    watch(viewType, () => {
        if (viewType.value == 'quickpitch') {
            canFetch.value = true;
            currentModel.value.filters['quickpitch'] = 1
        }else{
            canFetch.value = true;
            currentModel.value.filters['quickpitch'] = 0 
        }
    } );

    return {
        search,
        loadProposals,
        setViewType,
        filters,
        viewType,
        proposals
    };
});


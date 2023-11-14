import { AxiosError } from "axios";
import {defineStore, storeToRefs} from "pinia";
import { Ref, onMounted, ref, watch } from "vue";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";
import ProposalFilters from "@apps/catalyst-explorer/models/proposal-filters";
import Proposal from "@apps/catalyst-explorer/models/proposal";
import {useFiltersStore} from "@/global/stores/filters-stores";
import axios from "@/global/utils/axios";


export const useProposalsStore = defineStore('proposals', () => {
    let filters: Ref<ProposalFilters|null> = ref(null);
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

    function getRandomElementFromArray(array: any[]) {
    return array[Math.floor(Math.random() * array.length)];
    }

    async function search(f: ProposalFilters) {
        filters.value = f;
        try {
            const {data} = await axios.get(
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
            const {data} = await axios.get(
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


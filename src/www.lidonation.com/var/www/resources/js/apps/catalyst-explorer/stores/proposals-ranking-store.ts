import { AxiosError } from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import Rank from "../models/rank";
import Proposal from "../models/proposal";
import route from "ziggy-js";

export const useProposalsRankingStore = defineStore('proposals-ranking', () => {
    let ranks = ref<Rank[]>([]);

    async function loadRankings() {
        try {
            const {data} = await window.axios.get(`/api/catalyst-explorer/proposals-ranks`);
            ranks.value = data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    async function updateSaveRanking(rankValue: number, proposal: Proposal, rank?: Rank) {
        if (rank?.model_id == proposal.id){
            await window.axios.patch(route('catalyst-explorer.ranks.update', {rank: rank.id}), {'rankValue': rankValue,})
                .then(async () => await loadRankings());

        } else {
            await window.axios.post(route('catalyst-explorer.ranks.store'), {'rankValue': rankValue, 'proposal': proposal.id})
                .then(async () => await loadRankings());
        }
    }

    return {
        loadRankings,
        updateSaveRanking,
        ranks,
    };
});


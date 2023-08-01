import { AxiosError } from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import Rank from "../models/rank";

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

    return {
        loadRankings,
        ranks,
    };
});


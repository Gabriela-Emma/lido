import {defineStore} from "pinia";
import {Ref, ref, watch} from "vue";
import route from "ziggy-js";
import { VARIABLES } from "../models/variables";
import axios from 'axios';
import { useStorage } from "@vueuse/core";

export const useChartsWidgetStore = defineStore('charts-widgets', () => {
    let proposals = ref([]);
    let proposers = ref(null);
    let proposerData = ref(null);
    let loadingProposals = ref(true);
    let emptyDataProposals = ref(false);
    let loadingTeams = ref(true);
    let emptyDataTeams = ref(false);
    let chartsProposalsOptions = ref([
        { 'label': 'Top Funded', 'value': 1 },
        { 'label': 'Top Budget', 'value': 2 }
    ])
    let selectedValue = useStorage<number>('chart-option', 1);
    let selectedFundId = ref()



    async function getTopProposals(fundId: number){
        loadingProposals.value = true;
        emptyDataProposals.value = false;
        try {
            const {data} = await axios.get(route("catalystExplorer.topFundedProposals"), {
                params: { [VARIABLES.FUNDS]: fundId, [VARIABLES.CHART_FUND_STATUS]: selectedValue.value },
            })
            if (data && Object.keys(data).length === 0) {
                console.log("Data is an empty object.");
                loadingProposals.value = false;
                emptyDataProposals.value = true;
            } else {
                proposals.value = data;
                loadingProposals.value = false;
                emptyDataProposals.value = false;
            }
        } catch (e) {
            console.log({e});
        }
    }


    async function getProposerData(fundId: number) {
        loadingTeams.value = true;
        emptyDataTeams.value = false;
        try {
            const {data} = await axios.get(route("catalystExplorer.topFundedTeams"), {
                params: { [VARIABLES.FUNDS]: fundId, [VARIABLES.CHART_FUND_STATUS]: selectedValue.value },
            })
            if (data && data.proposers.length === 0) {
                loadingTeams.value = false;
                emptyDataTeams.value = true;
            } else {
                proposers.value = data.proposers;
                proposerData.value = data;
                loadingTeams.value = false;
                emptyDataTeams.value = false;
            }
        } catch (e) {
            console.log({e});
        }
    }

    function updateSelectedValue(optionId: number){
        selectedValue.value = optionId;
    }

    function updateSelectedFundId(id: number){
        selectedFundId.value = id;
    }

    watch([selectedValue], () => {
        getTopProposals(selectedFundId.value);
        getProposerData(selectedFundId.value)
    }, { deep: true });

    return {
        proposals,
        loadingProposals,
        emptyDataProposals,
        loadingTeams,
        emptyDataTeams,
        chartsProposalsOptions,
        selectedValue,
        proposers,
        proposerData,
        getTopProposals,
        updateSelectedValue,
        updateSelectedFundId,
        getProposerData
    }
})
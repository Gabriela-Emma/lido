import {defineStore} from "pinia";
import {onMounted, ref, Ref} from "vue";
import DelegatorsService from "@apps/delegators/services/DelegatorsService";

export const useDelegatorsStore = defineStore('Delegators', () => {
    let poolDetails = ref(null);
    let poolBlocks = ref(null);
    let config = ref(null);
    let delegatorsService = new DelegatorsService;

    function init()
    {

        loadPoolDetails();
        loadPoolBlocks();
        loadConfig();
    }

    async function loadPoolDetails() {
        let poolDetailKeys = ['blocks_minted', 'blocks_epoch', 'live_stake'];

        let data = await delegatorsService.getPoolDetails();
        const filteredData = Object.fromEntries(Object.entries(data).filter(([key, value]) => poolDetailKeys.includes(key)));

        poolDetails.value = filteredData;
    }


    async function loadPoolBlocks() {
        let blockKeys = ['hash', 'date', 'epoch', 'slot', 'tx_count']
        let filteredData = [];

        let data = await delegatorsService.getPoolBlocks();
        data.forEach( (block) => {
            const filteredBlock = Object.fromEntries(Object.entries(block).filter(([key, value]) => blockKeys.includes(key)));
            filteredData.push(filteredBlock);
        });
        poolBlocks.value = filteredData;
    }

    async function loadConfig() {
        let configKeys = ['blockExplorer'];

        let data = await delegatorsService.getBlockfrostConfig();
        const filteredData = Object.fromEntries(Object.entries(data).filter(([key, value]) => configKeys.includes(key)));

        config.value = filteredData;
    }

    onMounted(init)

    return {
        poolDetails,
        poolBlocks,
        config,
    }
});

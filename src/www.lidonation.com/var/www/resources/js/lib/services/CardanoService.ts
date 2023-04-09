// @ts-nocheck
import WalletService, {NetworkMainnet, NetworkTestnet} from "./WalletService";
import {Memoize} from "typescript-memoize";
import { reject, some } from "lodash";
import BlockfrostKeysService from "./BlockfrostKeysService";

const axios = require('axios').default;

export default class CardanoService {
    walletService: WalletService;
    blockfrostUrl: any;
    projectId: any;
    poolId: any;
    api: any;

    constructor() {
        this.walletService = new WalletService();
    }

    public getPoolId() {
        return this.poolId;
    }

    public async getStakeAccount(stakeAddress: string) {
        if (typeof stakeAddress === 'undefined' || !stakeAddress) {
            return null;
        }
        return (await this.api.get(`/accounts/${stakeAddress}`))?.data;
    }

    public async getStakeRegistrations(stakeAddress: string) {
        if (typeof stakeAddress === 'undefined' || !stakeAddress) {
            return null;
        }
        return (await this.api.get(`/accounts/${stakeAddress}/registrations`))?.data;
    }

    public async getStakeHistory(stakeAddress: string) {
        if (typeof stakeAddress === 'undefined' || !stakeAddress) {
            return null;
        }
        return (await this.api.get(`/accounts/${stakeAddress}/history`))?.data;
    }

    public async getStakeRewards(stakeAddress: string) {
        if (typeof stakeAddress === 'undefined' || !stakeAddress) {
            return null;
        }
        return (await this.api.get(`/accounts/${stakeAddress}/rewards`, {params: {order: 'desc'}}))?.data;
    }

    public async getStakeAddress(walletAddress: string) {
        if (typeof walletAddress === 'undefined' || !walletAddress) {
            return null;
        }
        return (await this.api.get(`/addresses/${walletAddress}`))?.data.stake_address;
    }   

    public async getHandle(stakeAddress: string) {
        await this.init();
        let asset = (await this.api.get(`/accounts/${stakeAddress}/addresses/assets`))?.data[0].unit
        let assetName = (await this.api.get(`/assets/${asset}`))?.data.onchain_metadata.files[0].name
        return assetName;
    }

    public async getPoolBlocks() {
        await this.init();
        const upcomingBlocks = [
        //     {
        //         slot: 69334598,
        //         date: (new Date('08/19/2022 09:21:29 UTC')).toLocaleString()
        //     },
            // {
            //     slot: 68820020,
            //     date: (new Date('08/13/2022 10:25:11 UTC')).toLocaleString()
            // },
            // {
            //     slot: 68381070,
            //     date: (new Date('08/08/2022 08:29:21 UTC')).toLocaleString()
            // }
        ];
        const blocks = (await this.api.get(`/pools/${this.poolId}/blocks`, {params: {count: 21, order: 'desc'}}))?.data;
        const mintedBlocks = await axios.all(blocks.map(async (block) => {
            const res = await this.api.get(`/blocks/${block}`);
            return {
                date: (new Date(res.data.time * 1000)).toLocaleString(),
                ...res.data
            };
        }));
        return [
            ...(reject(upcomingBlocks, (b) => some(mintedBlocks, {slot: b.slot}))),
            ...mintedBlocks
        ];
    }

    public async getPoolDetails() {
        await this.init();
        return (await this.api?.get(`/pools/${this.poolId}`))?.data;
    }

    public async getParameters() {
        await this.init();
        return (await this.api?.get(`/epochs/latest/parameters`))?.data;
    }

    public async isLidoDelegate(stakeAddress: string) {
        await this.init();
        if (typeof stakeAddress === 'undefined' || !stakeAddress) {
            return false;
        }
        const res = await this.getStakeAccount(stakeAddress);
        return res.pool_id && res.pool_id == this.poolId;
    }

    protected async init() {
        if (!!this.api) {
            return;
        }
        const blockfrostKeysService = new BlockfrostKeysService();
        const keys = await blockfrostKeysService.getConfig();
        this.poolId = keys.poolId;
        this.blockfrostUrl = keys?.blockfrostUrl;
        this.api = axios.create({
            baseURL: this.blockfrostUrl,
            timeout: 5000,
            headers: {'project_id': keys?.projectId}
        });
    }
}

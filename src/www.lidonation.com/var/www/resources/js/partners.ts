import Alpine, {Alpine as AlpineType} from "alpinejs";
import {Axios, AxiosError} from "axios";
import {Cardano, UTxO} from "lucid-cardano";
import persist from '@alpinejs/persist';
import {walletLogin} from "./lib/utils/walletLogin";
import {cardanoWallet} from "./lib/utils/cardanoWallet";
import WalletService from "./lib/services/WalletService";
import focus from '@alpinejs/focus';

export {};
declare global {
    interface Window {
        Alpine: AlpineType;
        cardano: Cardano;
        delegationLearningModule: any;
        axios: Axios;
    }
}

Alpine.plugin(persist);
Alpine.plugin(focus);

Alpine.data('cardanoWallet', cardanoWallet.bind(Alpine));

Alpine.data('lidoPartners', function () {
    return {
        assets: null,
        partner: null,
        partnerLoading: false,

        notices: [],

        wallet: null,

        stakeAddr: null,
        walletBalance: null,
        walletAddr: null,
        walletName: this.$persist(null).using(localStorage),

        walletService: null,

        working: false,
        registering: false,
        walletLoading: false,

        async walletLogin(walletName: string) {
            try {
                const user = await walletLogin(walletName, this.stakeAddr, undefined, 'partner');
                if (!!user) {
                    location.reload();
                }
            } catch (e) {
                if (e?.response?.status === 401 || e?.response?.status === 404) {
                    // console.log(e);
                    this.$dispatch('new-notice', { name: 'Error', message: 'Failed to log you in. Have registered for the partner dashboard?', type: 'error'});
                } else {
                    this.$dispatch('new-notice', { name: 'Error', message: e.message || e.info, type: 'error'});
                }
            }
        },
        async init() {
            this.working = true;
            this.walletService = new WalletService();
            if (this.walletName) {
                await this.walletService.connectWallet(this.walletName);
                await this.getAssets();
                this.walletAddr = await this.walletService.getAddress();
                this.stakeAddr = await this.walletService.getStakeAddress();
            }
            this.working = false;
        },
        async walletLoaded(wallet) {
            // console.log({wallet});
        },
        async getPolicies() {
            try {
                const res = await window.axios.post('/api/partners/policies');
                return res.data;
            } catch (e: AxiosError | any) {
                console.log({e});
            }
        },
        async getAssets() {
            const policies = await this.getPolicies();
            const utxos = (await this.walletService?.lucidInstance?.wallet?.getUtxos())
                .filter(
                    (utxo: UTxO) =>
                        Object.keys(utxo.assets)
                            .filter(
                                asset => asset.includes(policies[0])
                            ).length > 0
                );
            const assetsPromises = utxos.map((utxo: UTxO) => utxo.assets)
                .map(asset => Object.keys(asset))
                .flat()
                .filter(asset => asset.includes(policies[0]))
                .map(async (asset) => {
                    //@todo parallelized this for when user has multiple assets
                    const res = await window.axios.get(`/api/cardano/assets/${asset}`);

                    let _asset = {
                        ...res.data,
                        ...res.data?.onchain_metadata,
                        metadata: res.data?.onchain_metadata,
                        image: res?.data?.onchain_metadata?.image.replace('ar://', 'https://arweave.net/')
                    }

                    delete _asset['onchain_metadata'];
                    return _asset;

                });
            Promise.all(assetsPromises).then((assets) => {
                this.assets = assets;
                for (let asset of this.assets) {
                    this.meta_data = asset.metadata;
                }
            });
        },
        registerPartner() {
            this.registering = true;
        },
        async partnerLogin(event) {
            // console.log({event});
        },
        async partnerLogout() {
            try {
                await window.axios.post('/api/partners/logout');
                location.reload();
            } catch (e: AxiosError | any) {
                console.log({e});
            }
        },
        async createPromo(asset) {
            try {
                const data = {
                    mint_tx: asset?.initial_mint_tx_hash,
                    policy: asset?.policy_id,
                    asset: asset?.asset_name
                };
                const res = await window.axios.post(`/api/promos/create`, data, {
                    headers: {
                        'Content-Type': 'multipart/json'
                    }
                });
                location.reload();
            } catch (e: AxiosError | any) {
                if (e?.response?.status === 404) {
                    // console.log(e);
                    this.$dispatch('new-notice', 'Unable to validate your nft. Please contact support.');
                } else {
                    this.$dispatch('new-notice', e.message || e.info);
                }
            }
        },
        async submitPartnerRegistration(event) {
            this.partnerLoading = true;
            const partner = {
                assets: this.assets.map(ass => ass.name),
                stake_address: this.stakeAddr,
                wallet_address: this.walletAddr,
                ...Object.fromEntries(new FormData(event.target))
            };
            try {
                const res = await window.axios.post(`/api/partners/create`, partner, {
                    headers: {
                        'Content-Type': 'multipart/json'
                    }
                });

                this.partner = res.data;
                location.reload();
            } catch (e: AxiosError | any) {
                // this.pushError({name: e.name, message: e?.response?.data?.message || e.message, type: 'error'})
                console.log({e});
            }
            this.partnerLoading = false;
        }
    }
}.bind(Alpine));


Alpine.start();

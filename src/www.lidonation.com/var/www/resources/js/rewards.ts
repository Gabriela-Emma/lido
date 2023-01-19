// @ts-nocheck
import Alpine, {Alpine as AlpineType} from 'alpinejs'
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Tooltip from "@ryangjchandler/alpine-tooltip";
import persist from '@alpinejs/persist';
import focus from '@alpinejs/focus';
import WalletService from "./lib/services/WalletService";
import {Cardano} from "lucid-cardano";
import {Axios} from "axios";
import {walletLogin} from "./lib/utils/walletLogin";
import {globalVideoPlayer} from "./lib/utils/globalVideoPlayer";
import {cardanoWallet} from "./lib/utils/cardanoWallet";

export {};
declare global {
    interface Window {
        Alpine: AlpineType;
        cardano: Cardano;
        delegationLearningModule: any;
        axios: Axios;
    }
}

Alpine.plugin(Clipboard);
Alpine.plugin(Tooltip);
Alpine.plugin(persist);
Alpine.plugin(focus);

Alpine.data('lidoRewards', function () {
    return {
        quiz: null,
        working: false,
        withdrawalsProcessed: null,
        walletName: this.$persist(null).using(localStorage),
        withdrawals: null,

        phuffyBalance: 0,

        wallet: null,
        user: null,
        userLoading: false,

        currPage: this.$persist('home'),

        showRewards: false,

        init() {
            if (!!this.walletName) {
                // fire off intent to connect wallet
                // listen to intent processing and show spinner
            }
        },

        getAssetLogo(reward) {
            if (!reward.asset_details?.metadata?.logo) {
                return null;
            }
            return `data:image/png;base64, ${reward.asset_details?.metadata?.logo}`;
        },

        getAssetTicker(reward) {
            return reward.asset_details?.metadata?.ticker;
        },

        getAssetName(reward) {
            return reward.asset_details?.metadata?.name || reward.asset_details?.asset_name;
        },

        get availableAdaRewards() {
            if (!this.wallet) {
                return false
            }
            return this.numberFormat(this.wallet?.withdrawable_amount / 1000000);
        },

        get controlledStake() {
            if (!this.wallet) {
                return false
            }
            return this.numberFormat(this.wallet?.controlled_amount / 1000000);
        },

        async withdrawalRewards() {
            this.working = true;
            try {
                // start processing withdrawal
                const processResponse = (await window.axios.post(`/api/rewards/withdrawals/process`, {address: this.wallet?.address}));
                setTimeout(async () => {
                    console.log({processResponse});

                    const walletService = new WalletService();
                    await walletService.connectWallet(this.wallet?.name);
                    if (!this.minterAddress?.address) {
                        this.minterAddress = (await window.axios.post(`/api/rewards/withdrawals/address`))?.data;
                    }

                    // get deposit
                    const rawTx = await walletService.payToAddress(this.minterAddress?.address, {lovelace: BigInt(2000000)});
                    const signedTx = await  rawTx.sign().complete();
                    this.paymentTx = await signedTx.submit();

                    // processing Withdrawal and send tx to backend
                    const withdrawalResponse = (await window.axios.post(`/api/rewards/withdrawals/withdraw`, {hash: this.paymentTx}));
                    this.withdrawalsProcessed = withdrawalResponse?.data;
                    this.working = false;
                }, 3000);
            } catch (e) {
                this.$dispatch('new-notice', e.message);
            }
        },

        async emailLogin(event) {
            const login = Object.fromEntries(new FormData(event.target));
            const user = {
                email: login.email,
                password: login.password
            };

            try {
                const res = await window.axios.post(`/api/rewards/login`, user);
            } catch (e) {
                if (e?.response?.status === 401) {
                    this.$dispatch('new-notice', {
                        name: 'Error',
                        message: 'Failed to log you in. You will be able to login after you earn your first reward? If you have already earned rewards, check your password or make sure you are connected with the correct wallet.',
                        type: 'error'
                    });
                } else {
                    this.$dispatch('new-notice', {
                        name: 'Error',
                        message: e?.response?.data?.message || e.message || e.info,
                        type: 'error'
                    });
                }
            }
        },

        async walletLogin(walletName: string) {
            try {
                const user = await walletLogin(
                    walletName,
                    this.wallet?.wallet_address,
                    'Lido User Login', 'reward',
                    {
                        stake_address: this.wallet?.stakeAddress
                    });
                if (!!user) {
                    location.reload();
                }
            } catch (e) {
                if (e?.response?.status === 401) {
                    this.$dispatch('new-notice', {
                        name: 'Error',
                        message: 'Failed to log you in. You will be able to login after you earn your first Lido reward?',
                        type: 'error'
                    });
                } else {
                    this.$dispatch('new-notice', {
                        name: 'Error',
                        message: e?.response?.data?.message || e.message || e.info,
                        type: 'error'
                    });
                }
            }
        },

        async walletLoaded(wallet) {
            this.wallet = wallet;
            this.working = false;
        },

        async withdraw() {
            this.working = true;
            try {
                this.withdrawals = (await window.axios.post(`/api/rewards/withdrawals`))?.data;
            } catch (e) {
                this.$dispatch('new-notice', e.message);
            }
            this.working = false;
        },
        numberFormat(value) {
            // Nine Zeroes for Billions
            return Math.abs(Number(value)) >= 1.0e+9

                ? (Math.abs(Number(value)) / 1.0e+9).toFixed(2) + "B"
                // Six Zeroes for Millions
                : Math.abs(Number(value)) >= 1.0e+6

                    ? (Math.abs(Number(value)) / 1.0e+6).toFixed(2) + "M"
                    // Three Zeroes for Thousands
                    : Math.abs(Number(value)) >= 1.0e+3

                        ? (Math.abs(Number(value)) / 1.0e+3).toFixed(2) + "K"

                        : Math.abs(Number(value));
        },
    }
}.bind(Alpine));
Alpine.data('cardanoWallet', cardanoWallet.bind(Alpine));

window.globalVideoPlayer = globalVideoPlayer;


window.Alpine = Alpine;
window.Alpine.start();

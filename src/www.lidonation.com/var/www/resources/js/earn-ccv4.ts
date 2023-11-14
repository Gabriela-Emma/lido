import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import './bootstrap';
import '../scss/earn-ccv4.scss';
import WalletService from './global/services/wallet-service';
import {C, Cardano} from "lucid-cardano";
import {Axios, AxiosError} from "axios";

export {};
declare global {
    interface Window {
        cardano: Cardano;
        delegationLearningModule: any;
        axios: Axios;
    }
}

Alpine.data('earnCcv4', function () {
    return {
        environment: 'test',

        wallet: null,
        stakeAddress: null,
        walletAddress: null,
        walletBalance: null,
        walletName: this.$persist(null).using(localStorage),
        walletLoaded: false,
        walletLoading: false,
        walletService: null,

        eligible: null,
        rewards: [],
        withdrawalCardanoScanLinks: [],
        cardanoScanRelativeUrl: null,
        async init() {
                this.walletService = new WalletService();

                if (window.location.origin === 'https://www.lidonation.com') {
                    this.environment = 'production';
                    this.cardanoScanRelativeUrl = `https://cardanoscan.io/transaction/`;
                }else {
                    this.cardanoScanRelativeUrl =`https://preview.cardanoscan.io/transaction/`;
                }

                if (!!this.walletName) {
                    await this.enableWallet(this.walletName);
                }
        },
        async enableWallet(wallet) {
            this.walletLoading = true;
            this.walletName = wallet;
            try {
                await this.walletService.connectWallet(this.walletName);
                await this.getWalletDetails();
            } catch (e) {
                this.walletLoaded = false;
                this.$dispatch('new-notice', {name: 'Wallet Error', message: 'Please check wallet connection, make sure you are in the right network. ', type: 'error'} as Notice);
            }

        },
        async getWalletDetails() {
            if (!this.walletName) {
                this.walletBalance = null;
                return false;
            }
            try {
                this.walletLoading = true;
                this.walletAddress = await this.walletService.getAddress();
                this.stakeAddress = <string>await this.walletService.getStakeAddress(this.walletName);
                this.walletBalance = await this.walletService.getBalance(this.walletName);
                // const walletBalance = C.Value.from_bytes(Buffer.from(this.walletBalance, 'hex')).coin().to_str();
                // if (!!walletBalance) {
                //     this.walletBalance = (walletBalance / 1000000).toLocaleString(undefined, {
                //         minimumFractionDigits: 2,
                //         maximumFractionDigits: 2
                //     });
                // }
                this.walletLoaded = true;
                this.walletLoading = false;
                return true;
            } catch (e) {
                this.walletLoaded = false;
                this.$dispatch('new-notice', {name: 'Wallet Error', message: 'Please check wallet connection, make sure you are in the right network. ', type: 'error'} as Notice);
            }
        },
        async checkEligibility() {
            const payload = {
                account: this.stakeAddress,
            };
            const params = new URLSearchParams(payload).toString();

            const res = await window.axios.get(`/api/ccv4/check-eligibility?` + params);
            if (res?.data) {
                this.withdrawalCardanoScanLinks = res?.data?.rewards?.withdrawal_txs.map((tx) => this.cardanoScanRelativeUrl + tx) ?? [];
                this.eligible = res?.data.eligibility;
                this.rewards = res?.data?.rewards?.awarded ?? [];
            }

        },
        async claimReward() {
            const res = await window.axios.post(`/api/ccv4/claim-rewards`, {
                'account': this.stakeAddress,
                'wallet_address': this.walletAddress
            });

            if (res?.data.rewards) {
                this.rewards = res?.data.rewards;
            } else {
                this.$dispatch('new-notice', {
                    name: res?.data.name,
                    message: res?.data.message,
                    type: res?.data.error
                } as Notice);
            }
        },
        switchWallet() {
            this.stakeAddress = null;
            this.walletAddress = null;
            this.walletBalance = null;
            this.walletName = null;
            this.walletLoaded = false;
            this.eligible = null;
        },
    }
}.bind(Alpine));

Livewire.start()

import WalletService from "../services/WalletService";
import {C} from "lucid-cardano";

/**
 * Requires alpine persist plugin.
 * Be sure to include it and add it via Alpine.plugin(persist); in your main js files
 */
export function cardanoWallet() {
    return {
        walletName: this.$persist(null).using(localStorage),
        api: null,
        lucid: null,
        walletBalance: null,
        lovelacesBalance: null,
        walletAddress: null,
        stakeAddress: null,
        walletLoading: false,
        walletService: null,

        init() {},

        supports(wallet) {
            if (typeof window.cardano === 'undefined') {
                return false;
            }
            return (!!window.cardano[wallet]) && typeof window.cardano[wallet] != 'undefined';
        },
        async enableWallet(_wallet = null) {
            const wallet = _wallet || this.walletName;
            this.walletLoading = true;
            if (typeof window.cardano === 'undefined' || !window?.cardano || !window.cardano[wallet]) {
                this.walletName = null;
                return Promise.reject(`${wallet} wallet not installed.`);
            }
            this.walletName = wallet;
            this.walletService = new WalletService();
            await this.walletService.connectWallet(this.walletName);
            await this.setWalletBalance();
            await this.setWalletAddress();
            this.$dispatch(
                'wallet-loaded',
                {
                    address: this.walletAddress,
                    stakeAddress: this.stakeAddress,
                    name: this.walletName,
                    balance: this.walletBalance
                }
            );
            this.walletLoading = false;
        },
        async setWalletAddress()
        {
            this.walletAddress = await this.walletService.getAddress();
            this.stakeAddress = await this.walletService.getStakeAddress();
        },
        async setWalletBalance() {
            if (!this.walletName) {
                this.walletBalance = null;
                return false;
            }
            this.walletLoading = true;
            this.walletBalance = await this.walletService.getBalance(this.walletName);
            const walletBalance = C.Value.from_bytes(Buffer.from(this.walletBalance, 'hex')).coin().to_str();

            if (!!walletBalance) {
                this.lovelacesBalance = BigInt(walletBalance);
                this.walletBalance = (this.lovelacesBalance / BigInt(1000000)).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
            this.walletLoading = false;
            return true;
        },
        async payToAddress(address, assets)
        {
            return await this.walletService.payToAddress(address, assets);
        }
    }
}

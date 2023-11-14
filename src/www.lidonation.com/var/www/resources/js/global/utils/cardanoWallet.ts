import WalletService from "../services/wallet-service";
// @ts-ignore
import { C } from "@lucid-cardano";

/**
 * Requires alpine persist plugin.
 * Be sure to include it and add it via Alpine.plugin(persist); in your main js files
 */

export default function cardanoWallet(this: any) {
    return {
        walletName: null, 
        api: null,
        lucid: null,
        walletBalance: null,
        lovelacesBalance: null,
        walletAddress: null,
        stakeAddress: null,
        walletLoading: false,
        walletService: null,
        init(){
            this.walletName= localStorage.getItem('walletName')
        },
        supports(wallet: string) {
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
            localStorage.setItem("walletName", wallet);
            this.walletService = new WalletService();
            await this.walletService.connectWallet(this.walletName);
            await this.setWalletAddress();
            this.walletLoading = false;
        },
        async setWalletAddress()
        {
            this.walletAddress = await this.walletService.getAddress();
            this.stakeAddress = await this.walletService.getStakeAddress();
            console.log({ addr: this.walletAddress, stake: this.stakeAddress });
            
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
        async payToAddress(address: any, assets: any)
        {
            return await this.walletService.payToAddress(address, assets);
        },

    }
}

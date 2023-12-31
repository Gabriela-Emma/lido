// @ts-nocheck
import { Blockfrost, Lucid, Network, Tx, C } from '@lucid-cardano';
import BlockfrostService from "./BlockfrostService"

export { };
declare global {
    interface Window {
        cardano: any;
        delegationLearningModule: any;
    }
}

export const NetworkTestnet = 'Testnet' as Network;
export const NetworkPreview = 'Preview' as Network;
export const NetworkMainnet = 'Mainnet' as Network;

export default class WalletService {
    private api: any;
    private lucid: any;
    private poolId: any;
    private blockfrostUrl: any;
    private projectId: any;

    constructor() { }

    public get lucidInstance() {
        return this.lucid;
    }

    public get apiInstance() {
        return this.api;
    }

    public getProviderUrl() {
        return this.blockfrostUrl;
    }

    public async delegate(wallet) {
        try {
            await this.init(wallet);
            const tx = await this.getDelegateTx(wallet);
            const signedTx = await tx.sign().complete();
            return signedTx.submit();
        } catch (e) {
            console.log({ e });
            throw e;
        }
    }

    public async payToAddress(address, assets) {
        return await new Tx(this.lucid)
            .payToAddress(address, assets)
            .validTo(Date.now() + 1000000)
            .complete();
    }

    public async expiredTx(wallet, assets, stakeAddr) {
        await this.init(wallet);
        if (!this.api) {
            return;
        }

        const addr = await this.getAddress(wallet);
        return await new Tx(this.lucid)
            .payToAddress(addr, assets)
            .validTo(Date.now() - 1000000)
            .addSigner(stakeAddr)
            .complete();
    }

    public async withdrawRewards(amount) {
        if (!this.api) {
            throw new Error(
                "Your wallet must be connected to withdraw rewards!"
            );
        }
        try {
            const rewardAddressHex = <string>(
                await this.lucid.wallet.rewardAddress()
            );
            const bech32 = C.Address.from_bytes(
                Buffer.from(rewardAddressHex, "hex")
            ).to_bech32();

            const tx = await new Tx(this.lucid)
                .withdraw(bech32, amount)
                .complete();
            const signedTx = await tx.sign().complete();
            return signedTx.submit();
        } catch (e) {
            throw e;
        }
    }

    public supports(wallet: string): boolean {
        if (typeof window.cardano === "undefined") {
            return false;
        }
        return !!window.cardano[wallet];
    }

    public async getDelegation(wallet: string) {
        await this.init(wallet);
        if (!this.api) {
            return;
        }
    }

    public async getStakeAddress(wallet: string = null) {
        if (!!wallet) {
            await this.init(wallet);
        }

        if (!this.api) {
            return;
        }

        return <string>await this.lucid.wallet.rewardAddress();
    }

    public async getParams(wallet: string) {
        await this.init(wallet);

        if (!this.api) {
            return;
        }
        return <string>await this.lucid.wallet.rewardAddress();
        // return C.Address.from_bytes(Buffer.from(rewardAddressHex, 'hex')).to_bech32();
    }

    public async getAddress() {
        return <string>await this.lucid.wallet.address();
    }

    public async confirmWalletOwnership(
        frostStakeAddress: string,
        userStakeAddress: string
    ) {
        return frostStakeAddress == userStakeAddress;
    }

    public async signMessage(wallet: string, msg: string) {
        await this.init(wallet);
        if (!this.api) {
            return;
        }
        const addresses = await this.api.getRewardAddresses();
        return <string>await this.api.signData(addresses[0], msg);
    }

    public async getBalance(wallet: string) {
        await this.init(wallet);
        if (!this.api) {
            return;
        }

        return <string>await this.api.getBalance();
    }

    public async connectWallet(wallet: string) {
        try {
            if (!this.lucid || typeof this.lucid === "undefined") {
                await this.init(wallet);
            } else {
                const api = await this.enableWallet(wallet);
                this.lucid.selectWallet(api);
                this.api = api;
            }
        } catch (e) {
            console.log({ e });
            return e.message;
        }
    }

    protected async enableWallet(wallet: string) {

        if (
            typeof window.cardano === "undefined" ||
            !window?.cardano ||
            !window.cardano[wallet]
        ) {
            return Promise.reject(`${wallet} wallet not installed.`);
        }
        console.log(`${wallet} enabled.`);
          return window.cardano[wallet]?.enable();
    }

    protected async getDelegateTx(wallet: string) {
        try {
            await this.init(wallet);
            if (!this.api) {
                return;
            }
            const rewardAddressHex = <string>(
                await this.lucid.wallet.rewardAddress()
            );

            return await new Tx(this.lucid)
                .delegateTo(rewardAddressHex, this.poolId)
                .complete();
        } catch (e) {
            throw e;
        }
    }

    protected async init(wallet: string) {
        if (!!this.lucid || typeof this.lucid !== "undefined") {
            const api = await this.enableWallet(wallet);
            this.lucid.selectWallet(api);
            this.api = api;
            return;
        }
        let lucid;

        try {
            const api = await this.enableWallet(wallet);

            if (!api) {
                console.log(`${wallet} not installed!`);
                return;
            }

            const networkId = await api.getNetworkId();
            const keys = await BlockfrostService.getConfig();
            const envNetworkId = keys?.network_id;
            const appUrl = keys?.app_url
            let network;
            switch (envNetworkId) {
                case "0":
                    if (networkId !== 0) {
                        throw new Error("Preview wallet needed");
                    }
                    network = "Preview";
                    break;

                case "1":
                    if (networkId !== 1) {
                        throw new Error("Mainnet wallet needed");
                    }
                    network = "Mainnet";
                    break; cardano.network.network_id

                default:
                    throw new Error("Invalid network");
            }

            lucid = await Lucid.new(
                new Blockfrost(`${appUrl}/api`),
                network
            );

            lucid = lucid.selectWallet(api);
            this.lucid = lucid;
            this.poolId = keys.poolId;
            this.api = api;
        } catch (e) {
            throw e;
        }
    }
}

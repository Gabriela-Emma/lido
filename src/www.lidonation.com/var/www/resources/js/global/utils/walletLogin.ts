// @ts-ignore
import { fromText, getAddressDetails } from "lucid-cardano";
import WalletService from "@/global/services/wallet-service";
import axios from "@/global/utils/axios";

export async function messageLogin(wallet: string, stakeAddress: string, redirectRoute = null, data = {}) {
    const messageHex = fromText('Lido Wallet Login')
    const signature = await (new WalletService())
        .signMessage(wallet, messageHex) as {};

    const {
        address: { hex: hexAddress },
    } = getAddressDetails(stakeAddress);
    const res = await axios.post("/wallet-login", {
        ...signature,
        stakeAddrHex: hexAddress,
        account: stakeAddress,
        redirect: redirectRoute,
        ...data,
    });
    return res?.data;
}

export async function txLogin(
    wallet: string,
    stakeAddr: string,
    redirectRoute: string | null = null,
    data = {}
) {
    const rawTx = await new WalletService().expiredTx(
        wallet,
        { lovelace: BigInt(0) },
        stakeAddr
    );
    const signedTx = (await rawTx?.sign().complete())?.toString();

    const res = await axios.post("/wallet-login", {
        txHash: signedTx,
        account: stakeAddr,
        redirect: redirectRoute,
        ...data,
    });
}

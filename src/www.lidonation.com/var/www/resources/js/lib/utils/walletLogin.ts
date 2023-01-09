import WalletService from "../services/WalletService";

export async function walletLogin(wallet: string, identifier, msg: string = 'Lido Partner Login', role: string = 'delegator', data = {}) {
    const signature = await (new WalletService())
        .signMessage(wallet, Buffer.from(msg)
            .toString('hex')) as {};

    const user = {
        [role]: identifier,
        ...signature,
        ...data
    };
    const res = await window.axios.post(`/api/${role}s/login`, user);
    return res?.data;
}

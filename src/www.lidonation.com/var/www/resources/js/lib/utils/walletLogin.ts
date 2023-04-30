import WalletService from "../services/WalletService";

export async function walletLogin(wallet: string, stakeAddress: string, redirectRoute = null, data = {}) {
    const signature = await (new WalletService())
        .signMessage(wallet, Buffer.from('Lido Wallet Login')
            .toString('hex')) as {};

    // const res = await window.axios.post((role == 'catalyst-explorer' || role =='earn/learn')?`/api/${role}/login`:`/api/${role}s/login`, user)
    const res = await window.axios.post('/wallet-login', {
        ...signature,
        account: stakeAddress,
        redirect: redirectRoute,
        ...data
    });
    return res?.data;
}

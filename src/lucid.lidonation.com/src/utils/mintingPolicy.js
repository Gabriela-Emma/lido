import lucidInstance from "./lucidInstance";
export default async function mintingPolicy(seed) {
    const lucid = await lucidInstance();
    lucid.selectWalletFromSeed(seed);
    const { paymentCredential } = lucid.utils.getAddressDetails(await lucid.wallet.address());
    const mintingPolicy = lucid.utils.nativeScriptFromJson({
        type: 'all',
        scripts: [
            {
                type: 'sig',
                keyHash: paymentCredential?.hash,
            },
        ],
    });
    return mintingPolicy;
}
//# sourceMappingURL=mintingPolicy.js.map
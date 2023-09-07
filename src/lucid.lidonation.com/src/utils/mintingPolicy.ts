import { MintingPolicy, PolicyId } from "lucid-cardano";
import lucidInstance from "./lucidInstance.js";


export default async function mintingPolicy(seed) {
    const lucid = await lucidInstance();
    lucid.selectWalletFromSeed(seed.toString());

    const { paymentCredential } = lucid.utils.getAddressDetails(
        await lucid.wallet.address(),
    );
    const mintingPolicy: MintingPolicy = lucid.utils.nativeScriptFromJson({
        type: 'all',
        scripts: [
            {
                type: 'sig',
                keyHash: paymentCredential?.hash!,
            },
        ],
    });
    return mintingPolicy;
}
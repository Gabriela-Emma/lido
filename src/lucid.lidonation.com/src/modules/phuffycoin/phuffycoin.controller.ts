import {Controller, Post, Req} from '@nestjs/common';
import {Request} from "express";
import {Blockfrost, Lucid, MintingPolicy, PolicyId, Unit, utf8ToHex} from "lucid-cardano";

@Controller('phuffycoin')
export class PhuffycoinController {
    @Post('claim')
    async claimPhuffy(@Req() request: Request) {
        const projectId = process.env.BLOCKFROST_PROJECT_ID || 'preview2QfIR5epKjaFmh54Id75yXAM7yStk3vc';
        const blockfrostUrl = projectId.includes('preview') ? "https://cardano-preview.blockfrost.io/api/v0" : "https://cardano-mainnet.blockfrost.io/api/v0"
        const cardanoNetwork = projectId.includes('preview') ? "Preview" : "Mainnet"

        const lucid = await Lucid.new(
            new Blockfrost(blockfrostUrl, projectId),
            cardanoNetwork,
        );

        lucid.selectWalletFromSeed(request.body?.seed);

        const { paymentCredential } = lucid.utils.getAddressDetails(
            await lucid.wallet.address(),
        );
        const mintingPolicy: MintingPolicy = lucid.utils.nativeScriptFromJson(
            {
                type: "all",
                scripts: [
                    { type: "sig", keyHash: paymentCredential?.hash! }
                ],
            },
        );

        const policyId: PolicyId = lucid.utils.mintingPolicyToId(mintingPolicy);

        // get utxos from browser
        const userAddress = request.body?.userAddress;
        const phuffyAmount = request.body?.phuffyAmount;
        const unit: Unit = policyId + utf8ToHex('PHUFFY');
        const tx = await lucid
            .newTx()
            .payToAddress(userAddress, {lovelace: BigInt(2000000), [unit]: BigInt(phuffyAmount)})
            .mintAssets({ [unit]: BigInt(phuffyAmount) })
            .validTo(Date.now() + 100000)
            .attachMintingPolicy(mintingPolicy)
            .attachMetadata(674, {msg: [request.body?.msg || 'PHUFFY Issued']})
            .complete();

        const signedTx = await tx.sign().complete();
        const txHash = await signedTx.submit();

        return {tx: txHash};
    }
}

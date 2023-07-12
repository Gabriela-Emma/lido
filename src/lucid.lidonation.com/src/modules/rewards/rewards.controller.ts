import {Controller, Post, Req} from '@nestjs/common';
import {Request} from "express";
import {Blockfrost, Lucid, PolicyId, Unit, fromText} from "lucid-cardano";

@Controller('rewards')
export class RewardsController {
    @Post('withdraw')
    async sendReward(@Req() request: Request) {
        const projectId = process.env.BLOCKFROST_PROJECT_ID || 'preview2QfIR5epKjaFmh54Id75yXAM7yStk3vc';
        const blockfrostUrl = projectId.includes('preview') ? "https://cardano-preview.blockfrost.io/api/v0" : "https://cardano-mainnet.blockfrost.io/api/v0"
        const cardanoNetwork = projectId.includes('preview') ? "Preview" : "Mainnet"

        const lucid = await Lucid.new(
            new Blockfrost(blockfrostUrl, projectId),
            cardanoNetwork,
        );

        lucid.selectWalletFromSeed(request.body?.seed);

        let tx = await lucid
            .newTx()
            .validTo(Date.now() + 100000)
            .attachMetadata(674, {msg: [request.body?.msg || 'Rewards Withdrawal']});

        const payments = request.body.payments;
        if (!payments.length) {
            return payments;
        }

        for (let i: number = 0; i < payments.length; i++) {
            const pmt = payments[i];
            const address = pmt.address;
            let amounts = {};
            if (pmt.lovelace) {
                amounts['lovelace'] = BigInt(pmt.lovelace);
            } else {
                amounts['lovelace'] = BigInt(2000000);
            }
            delete pmt.lovelace;
            delete pmt.address;
            Object.keys(pmt).forEach((asset) => {
                amounts = {
                    ...amounts,
                    [asset]: BigInt(pmt[asset])
                }
            });
            // tx = await lucid.newTx().compose(tx).payToAddress(address, amounts);
            tx = await tx.payToAddress(address, amounts);
        }

        const signedTx = await (await tx.complete()).sign().complete();
        const txHash = await signedTx.submit();

        return {tx: txHash};
    }

    protected async mintNft(nfts, lucid:Lucid){
        for (let i = 0; i < nfts.length; i++) {
            const nft = nfts[i];
            const mintingPolicy = await this.getPolicy(lucid);
            const policyId: PolicyId =
                lucid.utils.mintingPolicyToId(mintingPolicy);
            const unit: Unit = policyId + fromText(nft.key);
            const tx = await lucid
                .newTx()
                .payToAddress(nft.owner, {
                lovelace: BigInt(2000000),
                [unit]: 1n,
                })
                .mintAssets({ [unit]: 1n })
                .validTo(Date.now() + 100000)
                .attachMintingPolicy(mintingPolicy)
                .attachMetadata(721, {
                [policyId]: { [nft.key]: nft.metadata },
                })
                .complete();

            const signedTx = await tx.sign().complete();
            const hash = await signedTx.submit();

            return { hash };
        }
    }
}

import {Controller, Get, HttpException, HttpStatus, Post, Req} from '@nestjs/common';
import {Blockfrost, Lucid, MintingPolicy, PolicyId, toUnit, Unit, utf8ToHex} from "lucid-cardano";
import {Request} from "express";

@Controller('lido-minute')
export class LidoMinuteController {
    @Post('policy-id')
    public async policyId(@Req() request: Request) {
        let lucid; [lucid] = await this.getConfigs(request);
        lucid.selectWalletFromSeed(request?.body?.seed);
        const mintingPolicy = await this.getPolicy(lucid);
        const policy: PolicyId = lucid.utils.mintingPolicyToId(mintingPolicy);

        return {policy};
    }

    @Post('mint')
    public async mintNft(@Req() request: Request) {
        const nft = request?.body?.nft;
        let lucid; [lucid] = await this.getConfigs(request);

        lucid.selectWalletFromSeed(request?.body?.seed);
        const mintingPolicy = await this.getPolicy(lucid);
        const policyId: PolicyId = lucid.utils.mintingPolicyToId(mintingPolicy);
        const unit: Unit = policyId + utf8ToHex(nft.key);

        // console.log({policyId, unit, metadata: nft.metadata, files: nft.metadata.files});

        const tx = await lucid
            .newTx()
            .payToAddress(nft.owner, {lovelace: BigInt(2000000), [unit]: 1n })
            .mintAssets({ [unit]: 1n } )
            .validTo(Date.now() + 100000 )
            .attachMintingPolicy(mintingPolicy)
            .attachMetadata(721, {[policyId]: { [nft.key]: nft.metadata}})
            .complete();

        const signedTx = await tx.sign().complete();
        const hash = await signedTx.submit();

        return {hash};
    }

    @Post('royalty')
    public async setRoyalty(@Req() request: Request)
    {
        let lucid; [lucid] = await this.getConfigs(request);
        lucid.selectWalletFromSeed(request?.body?.seed);
        const mintingPolicy = await this.getPolicy(lucid);
        const policyId: PolicyId = lucid.utils.mintingPolicyToId(mintingPolicy);
        const addr = <string>await lucid.wallet.address();
        const royaltyAddress = [
            addr.substring(0, Math.floor(addr.length / 2)),
            addr.substring(Math.floor(addr.length / 2)),
        ];
        const tx = await lucid
            .newTx()
            .mintAssets({ [policyId]: 1n } )
            .validTo(Date.now() + 100000 )
            .attachMintingPolicy(mintingPolicy)
            .attachMetadata(777, {
                pct: "0.25",
                addr: royaltyAddress
            })
            .complete();

        const signedTx = await tx.sign().complete();
        const hash = await signedTx.submit();

        return {hash};
    }

    protected async  getPolicy(lucid: Lucid)
    {
        const { paymentCredential } = lucid.utils.getAddressDetails(
            await lucid.wallet.address(),
        );
        const mintingPolicy: MintingPolicy = lucid.utils.nativeScriptFromJson(
            {
                type: "all",
                scripts: [
                    {
                        type: "before",
                        slot: lucid.utils.unixTimeToSlot(1761942369100),
                    },
                    {
                        type: "sig",
                        keyHash: paymentCredential?.hash!
                    }
                ]
            }
        );

        return mintingPolicy;
    }

    protected async getConfigs(request: Request)
    {
        if (!request?.body?.seed) {
            throw new HttpException('Invalid Data', HttpStatus.NOT_ACCEPTABLE);
        }
        const projectId = process.env.BLOCKFROST_PROJECT_ID || 'preview2QfIR5epKjaFmh54Id75yXAM7yStk3vc';
        const blockfrostUrl = projectId.includes('preview') ? "https://cardano-preview.blockfrost.io/api/v0" : "https://cardano-mainnet.blockfrost.io/api/v0";
        const cardanoNetwork = projectId.includes('preview') ? "Preview" : "Mainnet";

        const lucid = await Lucid.new(
            new Blockfrost(blockfrostUrl, projectId),
            cardanoNetwork,
        );

        return [lucid, projectId, blockfrostUrl, cardanoNetwork];
    }
}
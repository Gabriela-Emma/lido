import lucidInstance from '@lido/utils/lucidInstance.js';
import { Controller, Post, Req } from '@nestjs/common';
import { Request } from 'express';
import {
  Blockfrost,
  Lucid,
  MintingPolicy,
  PolicyId,
  Unit,
  fromText,
} from 'lucid-cardano';

@Controller('rewards')
export class RewardsController {
  @Post('withdraw')
  async sendReward(@Req() request: Request) {
    const lucid = await lucidInstance();

    lucid.selectWalletFromSeed(
      request?.body?.seed
    );

    const payments = request.body.payments;
    
    if (!payments.length) {
      return payments;
    }

    let tx = await lucid
      .newTx()
      .validTo(Date.now() + 100000)

    let nfts = [];
    let nftMetadata = {};
    let policy;
    for (let i = 0; i < payments.length; i++) {

      let pmt = payments[i];

      if (pmt.nfts) {
        for (let n = 0; n < pmt.nfts.length; n++) {
          let nft = pmt.nfts[n];
          if (!!nft?.key){
            nfts.push(nft);
          }
        }
      }
      const address = pmt.address;
      let amounts = {};


      if (pmt.asset?.['lovelace']) {
        amounts['lovelace'] = BigInt(pmt.asset['lovelace']);
      } else {
        amounts['lovelace'] = BigInt(2000000);
      }
      delete pmt.asset?.['lovelace'];
      delete pmt.address;

      Object.keys(pmt.assets).forEach((asset) => {
        amounts = {
          ...amounts,
          [asset]: BigInt(pmt.assets[asset]),
        };
      });

      if (nfts.length != 0) {
        tx = await this.mintNft(nfts, amounts, tx, lucid, address);
        let metadata = Object.assign({}, ...nfts.map((nft) => ({ [nft?.key]: nft?.metadata })));
        nftMetadata = { ...nftMetadata ,...metadata}
        policy = lucid.utils.mintingPolicyToId(await this.getPolicy(lucid));
        nfts = [];
      } else {
        tx = await tx.payToAddress(address, amounts).attachMetadata(674, {
          msg: ['Rewards Withdrawal'],
        });
      }

    }

    if (Object.keys(nftMetadata).length > 0) { 
      const signedTx = await (await tx.attachMetadata(
        721, {[policy]: { ...nftMetadata }}
      ).complete()).sign().complete();

      const txHash = await signedTx.submit();
      return { tx: txHash };
    }
    
    const signedTx = await (await tx.complete()).sign().complete();
    const txHash = await signedTx.submit();

    return { tx: txHash };
  }

  async mintNft(nfts, amounts, tx, lucid: Lucid, address) {
    const mintingPolicy = await this.getPolicy(lucid);
    const policyId: PolicyId = lucid.utils.mintingPolicyToId(mintingPolicy);
    let nftTx = tx;

    if (Object.keys(amounts).length) {
      nftTx = tx.payToAddress(address, amounts);
    }

    for (let i = 0; i < nfts.length; i++) {
      let nft = nfts[i];
      const unit: Unit = policyId + fromText(nft.key);
      nftTx
        .payToAddress(address, {
          [unit]: 1n,
        })
        .mintAssets({ [unit]: 1n })
        .attachMintingPolicy(mintingPolicy)
    }

    return nftTx;
  }

  protected async getPolicy(lucid: Lucid) {
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
}

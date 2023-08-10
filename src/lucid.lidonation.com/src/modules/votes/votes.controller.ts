import { Controller, Post, Req } from '@nestjs/common';
import { C, fromHex} from 'lucid-cardano';
import { Request, json } from 'express';
import bf from '@lido/utils/blockfrost.js';
import {
  PublicKey,
  StakeCredential,

} from 'lucid-cardano/types/src/core/wasm_modules/cardano_multiplatform_lib_nodejs/cardano_multiplatform_lib';

@Controller('votes')
export class VotesController {
  @Post('decode-voter-transaction')
  async decodeVoterTxDetails(@Req() request: Request) {
    const voterTx = request.body.voterTransaction;

    // get transaction details from tx then extract voting_power and block_time
    const transactionDetails = await this.getTransactionDetails(voterTx.tx_hash);
    const votingPower = transactionDetails.data
      .output_amount
      .filter(amount => amount.unit == 'lovelace')[0]
      .quantity;
    const blockTime = transactionDetails.data
      .block_time;

    // 
    const voterKeys = await this.getVoterPublicKeys(voterTx.json_metadata.one);

    // get publicKey and reward address from CIP-36 json_metadata["2"]
    const publicKey: PublicKey = await this.getPublicKey(voterTx.json_metadata.two);
    const stakeCredential: StakeCredential = C.StakeCredential.from_keyhash(publicKey.hash());
    const rewardAddress = C.RewardAddress.new(
      1, stakeCredential
    )
      .to_address()
      .to_bech32(undefined);

    let result = {
      tx: voterTx.tx_hash,
      stake_pub: rewardAddress,
      stake_key: publicKey.to_bech32(),
      voting_power: votingPower / 1000000,
      created_at: transactionDetails.data.block_time,
      voter_pub: voterKeys,
    }

    return { data: result };
  }

  protected async getVoterPublicKeys(one: Object|string) {
    const delegators = [];
    let count = 0;
    let votersPublicKeys = [];

    if ((typeof one) === 'string') {
      delegators.push([one, 1]);
    } else {
      const DelegatorsArr = Object.values(one);
      DelegatorsArr.forEach(async (delegator) => {
        delegators.push(delegator);
        count++
      });
    }
    
    for (let i = 0; i < delegators.length; i++) {
      const delegator = delegators[i];
      let publicKey = (await this.getPublicKey(delegator[0])).to_bech32();
      let weight = delegator[1];
      votersPublicKeys.push([publicKey, weight]);
    }

    return JSON.stringify(votersPublicKeys).slice(2, -2);
  }

  protected async getPublicKey(two: string): Promise<PublicKey> {
    const hexTwo = await this.CBORByteArrayToHexString(two);

    return C.PublicKey.from_bytes(
      fromHex(hexTwo)
    );
  };

  protected async getTransactionDetails(txHash: string): Promise<any> {
    const txDetails = await bf({
      endpoint: `/txs/${txHash}`,
      method: 'GET'
    });

    return { data: txDetails };
  }

  protected async CBORByteArrayToHexString(byte: string): Promise<string> {
    return (byte.slice(0, 2) == '0x')
      ? byte.slice(2, byte.length)
      : byte;
  }
}
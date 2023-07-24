import {Controller, Get, Param, Post, Req} from "@nestjs/common";
import {Request} from "express";
import {getEpoch} from "../../utils/unix2epoch.js"
import mintingPolicy from '@lido/utils/mintingPolicy.js';
import lucidInstance from "@lido/utils/lucidInstance.js";
@Controller('cardano')
export class CardanoController {
  @Post('mint')
  public async mintNft(@Req() request: Request) {}

  @Get('asset/:asset')
  public async asset(@Param('asset') id: string, @Req() request: Request) {
    //@todo return asset. May be time to create a blockfrost passthrough proxy
  }

  @Get('epoch')
  async epoch(@Req() request: Request) {

    return await getEpoch(request.query.date) 

  }

  @Post('policy')
  async name(@Req() request: Request) {
    const lucid = await lucidInstance()
    const policy = await mintingPolicy(request?.query?.seed)
    return lucid.utils.mintingPolicyToId(policy)
  }
}
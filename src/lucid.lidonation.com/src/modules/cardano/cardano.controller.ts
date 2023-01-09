import {Controller, Get, Param, Post, Req} from "@nestjs/common";
import {Request} from "express";

@Controller('lido-minute')
export class CardanoController {
    @Post('mint')
    public async mintNft(@Req() request: Request) {

    }

    @Get('asset/:asset')
    public async asset(@Param('asset') id: string, @Req() request: Request) {
        //@todo return asset. May be time to create a blockfrost passthrough proxy
    }
}
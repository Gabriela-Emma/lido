import { Module } from '@nestjs/common';
import { IpfsController } from "./ipfs.controller.js";

@Module({
    controllers: [IpfsController]
})
export class IpfsModule {}

import { Module } from '@nestjs/common';
import {WalletController} from "@lido/modules/wallet/wallet.controller.js";

@Module({
  controllers: [WalletController]
})
export class WalletModule {}

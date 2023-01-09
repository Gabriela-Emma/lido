import { Module } from '@nestjs/common';
import {PhuffycoinController} from "@lido/modules/phuffycoin/phuffycoin.controller.js";

@Module({
  controllers: [PhuffycoinController]
})
export class PhuffycoinModule {}

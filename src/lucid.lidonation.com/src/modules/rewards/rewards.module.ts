import { Module } from '@nestjs/common';
import {RewardsController} from "@lido/modules/rewards/rewards.controller.js";

@Module({
  controllers: [RewardsController]
})
export class RewardsModule {}

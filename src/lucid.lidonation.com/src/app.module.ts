import { Module } from '@nestjs/common';
import { ConfigModule } from '@nestjs/config';
import { AppController } from './app.controller.js';
import { AppService } from './app.service.js';
import { PhuffycoinModule } from './modules/phuffycoin/phuffycoin.module.js';
import { WalletModule } from './modules/wallet/wallet.module.js';
import { LidoMinuteModule } from './modules/lido-minute/lido-minute.module.js';
import { CardanoModule } from './modules/cardano/cardano.module.js';
import { RewardsModule } from './modules/rewards/rewards.module.js';
import { VotesModule } from './modules/votes/votes.module.js';

@Module({
  imports: [
    PhuffycoinModule,
    WalletModule,
    LidoMinuteModule,
    CardanoModule,
    RewardsModule,
    VotesModule,
    ConfigModule.forRoot(),
  ],
  controllers: [AppController],
  providers: [AppService],
})
export class AppModule { }

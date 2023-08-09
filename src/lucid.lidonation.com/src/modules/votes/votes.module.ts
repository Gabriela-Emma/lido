import { Module } from '@nestjs/common';
import { VotesController } from './votes.controller.js';

@Module({
  controllers: [VotesController],
})
export class VotesModule {}

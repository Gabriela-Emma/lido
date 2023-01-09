import { Module } from '@nestjs/common';
import {CardanoController} from "./cardano.controller.js";

@Module({
    controllers: [CardanoController]
})
export class CardanoModule {}

import { Module } from '@nestjs/common';
import {LidoMinuteController} from "./lido-minute.controller.js";

@Module({
    controllers: [LidoMinuteController]
})
export class LidoMinuteModule {}

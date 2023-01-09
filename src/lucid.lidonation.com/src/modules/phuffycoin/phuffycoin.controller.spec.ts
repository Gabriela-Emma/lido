import { Test, TestingModule } from '@nestjs/testing';
import { PhuffycoinController } from './phuffycoin.controller';

describe('PhuffycoinController', () => {
  let controller: PhuffycoinController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [PhuffycoinController],
    }).compile();

    controller = module.get<PhuffycoinController>(PhuffycoinController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});

import {Controller, Get, Param, Post, Req} from "@nestjs/common";
import {Request} from "express";
import Moralis from 'moralis';

@Controller('ipfs')
export class IpfsController {
  @Post('upload')
  public async upload(@Req() request: Request) {
    let fileName = request?.body?.fileName;
    let fileContent = request?.body?.fileContent;

    try {
        let api_key = process.env.MORALIS_API_KEY
        
        await Moralis.start({ apiKey: api_key});
        
    } catch (error) {
        
    }

    const uploadArray = [
        {
            path: fileName,
            content: fileContent
        },
    ];

    let link;
    await Moralis.EvmApi.ipfs.uploadFolder({
            abi: uploadArray,
        }).then((res) => {
            link = res.toJSON();
        });
    
    return {ipfsPath: link};
  }
}
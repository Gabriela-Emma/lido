import { Blockfrost, Lucid } from "lucid-cardano";

export default async function lucidInstance() {
        const projectId =
          process.env.BLOCKFROST_PROJECT_ID ||
          'preview2QfIR5epKjaFmh54Id75yXAM7yStk3vc';
        const blockfrostUrl = projectId.includes('preview')
          ? 'https://cardano-preview.blockfrost.io/api/v0'
          : 'https://cardano-mainnet.blockfrost.io/api/v0';
        const cardanoNetwork = projectId.includes('preview')
          ? 'Preview'
          : 'Mainnet';

        const lucid = await Lucid.new(
          new Blockfrost(blockfrostUrl, projectId),
          cardanoNetwork,
        );
        
        return lucid;
}

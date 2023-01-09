<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cardano Pool Hash
    |--------------------------------------------------------------------------
    |
    | LIDO Nation Cardano Pool Hash
    |
    */
    'cardanoServiceProvider' => \App\Services\Providers\BlockfrostProvider::class,
    'hash' => env('CARDANO_POOL_HASH'),
    'network-argument' => env('CARDANO_NETWORK_ARGUMENT', '--testnet-magic 2'),
    'explorer' => env('CARDANO_TX_EXPLORER', '//cexplorer.io'),
    'graphQLEndpoint' => env('CARDANO_GRAPHQL_ENDPOINT', 'http://lidolovelace-hasura-sevice:8080/v1/graphql'),
    'lucidEndpoint' => env('CARDANO_LUCID_ENDPOINT', 'http://localhost:3000'),
    'network' => env('CARDANO_NETWORK', 'preview'),
    'pool' => [
        'hash' => env('CARDANO_POOL_HASH'),
        'block_explorer' => env('CARDANO_BLOCK_EXPLORER', '//cexplorer.io'),
        'stake_address' => env('CARDANO_POOL_STAKE_ADDRESS'),
    ],

    'mint' => [
        'payment-address' => env('CARDANO_MINT_PAYMENT_ADDRESS'),
        'policy-id' => env('CARDANO_MINT_POLICY_ID'),
        'token-name' => env('CARDANO_MINT_TOKEN_NAME', '4c49444f'),
        'policies' => [
            'lido_delegate' => env('CARDANO_LIDO_DELEGATE_POLICY_ID'),
            'phuffy_voter' => env('CARDANO_PHUFFY_VOTER_POLICY_ID'),
            'phuffycoin' => env('CARDANO_PHUFFY_COIN_POLICY_ID'),
            'maji' => env('CARDANO_MAJI_COIN_POLICY_ID'),
        ],
        'addresses' => [
            'mint' => env('CARDANO_MINT_PAYMENT_ADDRESS'),
            'treasurer' => env('CARDANO_PHUFFY_TREASURER_ADDRESS'),
            'governor' => env('CARDANO_PHUFFY_GOVERNOR_ADDRESS'),
            'escrow' => env('CARDANO_PHUFFY_ESCROW_ADDRESS'),
        ],
        'tokens' => [
            'phuffy_coin' => [
                'name' => env('CARDANO_PHUFFY_COIN_NAME', '504855464659'),
                // 'holding-address' => env('CARDANO_PHUFFY_CAUSE_PAYMENT_ADDRESS')
            ],
            'lido_coin' => [
                'name' => env('CARDANO_LIDO_TOKEN_NAME', '6c69646f'),
            ],
            'maji_coin' => [
                'name' => env('CARDANO_MAJI_TOKEN_NAME', '6d696a69'),
            ],
            'lido_delegate_nft' => [
                'description' => 'LIDO Delegate Access',
                'image' => 'ipfs://QmU8P1qKoPSL3ab7yUZwMJezUjLiUuZ9SLS8DxvLh7gdnM',
                'name' => env('CARDANO_LIDO_NFT_NAME', 'LIDOAuthDelegate'),
            ],
        ],
    ],
];

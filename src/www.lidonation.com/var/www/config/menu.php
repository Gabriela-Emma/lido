<?php

return [
    new \Illuminate\Support\Fluent([
        'title' => 'Getting Started',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'What is Cardano',
                'route_type' => 'post_id_or_slug',
                'route' => 'what-is-cardano-and-how-does-it-use-the-blockchain'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'What is staking',
                'route_type' => 'post_id_or_slug',
                'route' => 'what-is-the-point-of-buy-ada-and-staking-in-cardano'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'How do I buy Ada',
                'route_type' => 'post_id_or_slug',
                'route' => 'how-do-i-buy-ada'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'How to stake your Ada',
                'route_type' => 'post_id_or_slug',
                'route' => 'how-to-stake-your-ada'
            ])
        ]
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Keep Learning',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => '',
                'route_type' => 'route_name',
                'route' => 'library'
            ]),
            new Illuminate\Support\Fluent([
                'title' => '',
                'route_type' => 'route_name',
                'route' => 'lido-minute'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Topics',
                'items' => [
                    new Illuminate\Support\Fluent([
                        'title' => 'News',
                        'cat_id_or_slug' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Decentralization',
                        'route_type' => 'cat_id_or_slug',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Blockchain',
                        'route_type' => 'cat_id_or_slug',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Cardano',
                        'route_type' => 'cat_id_or_slug',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Lido Nation',
                        'route_type' => 'cat_id_or_slug',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Project Catalyst',
                        'route_type' => 'cat_id_or_slug',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Projects',
                        'route_type' => 'cat_id_or_slug',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Reviews',
                        'route_type' => 'cat_id_or_slug',
                        'route' => ''
                    ])
                ]
            ]),
        ]
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Participate',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Every Epoch',
                'route_type' => 'route_name',
                'route' => 'library'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Bazaar',
                'route_type' => 'route_name',
                'route' => 'lido-minute'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Community Calendar',
                'route_type' => 'route_name',
                'route' => 'lido-minute'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Contribute',
                'route_type' => 'route_name',
                'route' => 'lido-minute'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Advertise',
                'route_type' => 'route_name',
                'route' => 'lido-minute'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Nfts',
                'items' => [
                    new Illuminate\Support\Fluent([
                        'title' => 'A Day at the Lake',
                        'route_type' => 'route_name',
                        'route' => ''
                    ]),
                ]
            ])
        ]
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Project Catalyst',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Voter Tool',
                'route_type' => 'route_name',
                'route' => 'library'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'My Bookmarks',
                'route_type' => 'route_name',
                'route' => 'lido-minute'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Catalyst API',
                'route_type' => 'route_name',
                'route' => 'lido-minute'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Lido Nation Projects',
                'route_type' => 'route_name',
                'route' => 'lido-minute'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Catalyst Explorer',
                'items' => [
                    new Illuminate\Support\Fluent([
                        'title' => 'Explorer Home',
                        'route_type' => 'route_name',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Proposals',
                        'route_type' => 'route_name',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Proposers',
                        'route_type' => 'route_name',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Groups',
                        'route_type' => 'route_name',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Funds',
                        'route_type' => 'route_name',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Charts',
                        'route_type' => 'route_name',
                        'route' => ''
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Monthly Reports',
                        'route_type' => 'route_name',
                        'route' => ''
                    ]),
                ]
            ])
        ]
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Stake Pool: LIDO',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Delegators',
                'route_type' => 'post_id_or_slug',
                'route' => 'what-is-cardano-and-how-does-it-use-the-blockchain'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'The pool',
                'route_type' => 'post_id_or_slug',
                'route' => 'what-is-the-point-of-buying-ada-and-staking-in-cardano'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Phuffycoin',
                'route_type' => 'post_id_or_slug',
                'route' => 'how-to-buy-cardano-ada'
            ])
        ]
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'About',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'The Team',
                'route_type' => 'post_id_or_slug',
                'route' => 'what-is-cardano-and-how-does-it-use-the-blockchain'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Privacy Policy',
                'route_type' => 'post_id_or_slug',
                'route' => 'what-is-the-point-of-buying-ada-and-staking-in-cardano'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Financial Details',
                'route_type' => 'post_id_or_slug',
                'route' => 'how-to-buy-cardano-ada'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Contact Us',
                'route_type' => 'post_id_or_slug',
                'route' => 'how-to-stake-ada'
            ])
        ]
    ]),
];

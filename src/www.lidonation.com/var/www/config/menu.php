<?php

return [
    new \Illuminate\Support\Fluent([
        'title' => 'Getting Started',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'What is Cardano',
                'route_type' => 'url',
                'route' => 'what-is-cardano-and-how-does-it-use-the-blockchain',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'What is staking',
                'route_type' => 'url',
                'route' => 'what-is-the-point-of-buying-ada-and-staking-in-cardano',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'How do I buy Ada',
                'route_type' => 'url',
                'route' => 'how-to-buy-cardano-ada',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'How to stake your Ada',
                'route_type' => 'url',
                'route' => 'how-to-stake-ada',
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Participate',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Every Epoch',
                'route_type' => 'url',
                'route' => 'delegators#everyEpoch',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Bazaar',
                'route_type' => 'route_name',
                'route' => 'bazaar',
            ]),
            //            new Illuminate\Support\Fluent([
            //                'title' => 'Community Calendar',
            //                'route_type' => 'route_name',
            //                'route' => 'lido-minute'
            //            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Contribute',
                'route_type' => 'route_name',
                'route' => 'contributeContent',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Advertise',
                'route_type' => 'route_name',
                'route' => 'lido-minute',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Nfts',
                'items' => [
                    new Illuminate\Support\Fluent([
                        'title' => 'A Day at the Lake',
                        'route_type' => 'route_name',
                        'route' => 'lido-minute-nft',
                    ]),
                ],
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Keep Learning',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Library',
                'route_type' => 'route_name',
                'route' => 'library',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Lido Minute',
                'route_type' => 'route_name',
                'route' => 'lido-minute',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Tags',
                'route_type' => 'route_name',
                'route' => 'tags',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Topics',
                'items' => [
                    new Illuminate\Support\Fluent([
                        'title' => 'News',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'news-and-interviews',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Decentralization',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'decentralization',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Blockchain',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'blockchain',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Cardano',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'cardano-blockchain',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Lido Nation',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'lido-nation-news',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Project Catalyst',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'project-catalyst',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Projects',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'blockchain-projects',
                    ]),
                    //                    new Illuminate\Support\Fluent([
                    //                        'title' => 'Reviews',
                    //                        'route_type' => 'cat_id_or_slug',
                    //                        'route' => ''
                    //                    ])
                ],
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Project Catalyst',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Voter Tool',
                'route_type' => 'route_name',
                'route' => 'projectCatalyst.voterTool',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'My Bookmarks',
                'route_type' => 'route_name',
                'route' => 'projectCatalyst.bookmarks',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Catalyst API',
                'route_type' => 'url',
                'route' => '/catalyst-explorer/api',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Lido Nation Projects',
                'route_type' => 'route_name',
                'route' => 'lido-blockchain-labs.nairobi',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Catalyst Explorer',
                'items' => [
                    //                    new Illuminate\Support\Fluent([
                    //                        'title' => 'Explorer Home',
                    //                        'route_type' => 'route_name',
                    //                        'route' => 'projectCatalyst.'
                    //                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Proposals',
                        'route_type' => 'route_name',
                        'route' => 'catalystExplorer.proposals',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'People',
                        'route_type' => 'route_name',
                        'route' => 'catalystExplorer.people',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Proposal Assessments',
                        'route_type' => 'route_name',
                        'route' => 'catalystExplorer.assessments',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Groups',
                        'route_type' => 'route_name',
                        'route' => 'catalystExplorer.groups',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Funds',
                        'route_type' => 'route_name',
                        'route' => 'catalystExplorer.funds',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Charts',
                        'route_type' => 'route_name',
                        'route' => 'projectCatalyst.dashboard',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Monthly Reports',
                        'route_type' => 'route_name',
                        'route' => 'catalystExplorer.reports',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'CCV4 Results',
                        'route_type' => 'route_name',
                        'route' => 'projectCatalyst.votes.ccv4',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Weekly Townhall',
                        'route_type' => 'url',
                        'route' => 'https://bit.ly/catalyst-townhall',
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Sign in',
                        'route_type' => 'route_name',
                        'route' => 'catalystExplorer.login',
                        'guest' => true,
                    ]),
                ],
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Stake Pool: LIDO',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Delegators',
                'route_type' => 'route_name',
                'route' => 'delegators',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'The pool',
                'route_type' => 'route_name',
                'route' => 'lido-pool',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Phuffycoin',
                'route_type' => 'route_name',
                'route' => 'phuffycoin',
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'About',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'The Team',
                'route_type' => 'route_name',
                'route' => 'team',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Privacy Policy',
                'route_type' => 'route_name',
                'route' => 'privacyPolicy',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Financial Details',
                'route_type' => 'route_name',
                'route' => 'financial-details',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Contact Us',
                'route_type' => 'route_name',
                'route' => 'community',
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => '',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'My Lido Rewards',
                'route_type' => 'route_name',
                'route' => 'rewards',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Lido Earn',
                'route_type' => 'route_name',
                'route' => 'earn.home',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Jifunze upate tuzo',
                'route_type' => 'url',
                'route' => 'https://www.lidonation.com/sw/earn/learn',
            ]),
        ],
    ]),
];

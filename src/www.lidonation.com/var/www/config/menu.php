<?php

return [
    new \Illuminate\Support\Fluent([
        'title' => 'Getting Started',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'What is Cardano',
                'route_type' => 'route_name',
                'route' => 'what-is-cardano',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'What is staking',
                'route_type' => 'route_name',
                'route' => 'what-is-staking',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'How do I buy Ada',
                'route_type' => 'route_name',
                'route' => 'how-to-buy-ada',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'How to stake your Ada',
                'route_type' => 'route_name',
                'route' => 'how-to-stake-ada',
                'navigate' => 'livewire',
                'eager' => true,
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
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Bazaar',
                'route_type' => 'route_name',
                'route' => 'bazaar',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Contribute',
                'route_type' => 'route_name',
                'route' => 'contribute.home',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Advertise',
                'route_type' => 'route_name',
                'route' => 'lido-minute',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Nfts',
                'items' => [
                    new Illuminate\Support\Fluent([
                        'title' => 'A Day at the Lake',
                        'route_type' => 'route_name',
                        'route' => 'lido-minute-nft',
                        'navigate' => 'livewire',
                        'eager' => true,
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
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Lido Minute',
                'route_type' => 'route_name',
                'route' => 'lido-minute',
                'navigate' => 'livewire',
                'eager' => true,

            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Tags',
                'route_type' => 'route_name',
                'route' => 'tags',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Topics',
                'items' => [
                    new Illuminate\Support\Fluent([
                        'title' => 'News',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'news-and-interviews',
                        'navigate' => 'livewire',
                        'eager' => true,
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Decentralization',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'decentralization',
                        'navigate' => 'livewire',
                        'eager' => true,
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Blockchain',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'blockchain',
                        'navigate' => 'livewire',
                        'eager' => true,
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Cardano',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'cardano-blockchain',
                        'navigate' => 'livewire',
                        'eager' => true,
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Lido Nation',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'lido-nation-news',
                        'navigate' => 'livewire',
                        'eager' => true,
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Project Catalyst',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'project-catalyst',
                        'eager' => true,
                    ]),
                    new Illuminate\Support\Fluent([
                        'title' => 'Projects',
                        'route_type' => 'cat_id_or_slug',
                        'route' => 'blockchain-projects',
                        'eager' => true,
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
    new Illuminate\Support\Fluent([
        'title' => 'Catalyst Explorer',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Explorer Home',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.home',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Voter Tool',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.voter-tool',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Proposals',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.proposals',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'People',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.people.index',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Proposal Assessments',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.assessments',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Groups',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.groups',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Funds',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.funds.index',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Charts',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.charts',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Monthly Reports',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.reports',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'CCV4 Results',
                'route_type' => 'route_name',
                'route' => 'projectCatalyst.votes.ccv4',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'My Bookmarks',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.myBookmarks',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Catalyst API',
                'route_type' => 'url',
                'route' => '/catalyst-explorer/api',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Weekly Townhall',
                'route_type' => 'url',
                'route' => 'https://bit.ly/catalyst-townhall',
                'target' => '_blank',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Sign in',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.login',
                'guest' => true,
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Stake Pool: LIDO',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Delegators',
                'route_type' => 'route_name',
                'route' => 'delegators.home',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'The pool',
                'route_type' => 'route_name',
                'route' => 'lido-pool',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Phuffycoin',
                'route_type' => 'route_name',
                'route' => 'phuffycoin.home',
                'navigate' => 'livewire',
                'eager' => true,
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
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Privacy Policy',
                'route_type' => 'route_name',
                'route' => 'privacyPolicy',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Financial Details',
                'route_type' => 'route_name',
                'route' => 'financial-details',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Contact Us',
                'route_type' => 'route_name',
                'route' => 'community',
                'navigate' => 'livewire',
                'eager' => true,
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => '',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'My Lido Rewards',
                'route_type' => 'route_name',
                'route' => 'rewards.index',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Lido Earn',
                'route_type' => 'route_name',
                'route' => 'earn.home',
                'eager' => false,
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Jifunze upate tuzo',
                'route_type' => 'url',
                'route' => 'sw/earn/learn',
                'eager' => false,
            ]),
        ],
    ]),
];

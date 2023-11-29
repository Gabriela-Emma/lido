<?php

return [
    new Illuminate\Support\Fluent([
        'title' => 'Home',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.home',
    ]),
    new Illuminate\Support\Fluent([
        'title' => 'Proposals',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.proposals',
    ]),
    new Illuminate\Support\Fluent([
        'title' => 'People',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.people.index',
    ]),
    new Illuminate\Support\Fluent([
        'title' => 'Charts',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.charts',
    ]),
    new Illuminate\Support\Fluent([
        'title' => 'Voter Tool',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.voter-tool',
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Proposals',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'All Proposals',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.proposals',
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Proposal Reviews',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.assessments'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Monthly Reports',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.reports'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Funds',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.funds.index'
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'People',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Proposers',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.people.index'
            ]), 
            new Illuminate\Support\Fluent([
                'title' => 'Groups',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.groups'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'dReps',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.dReps.index'
            ]),
                    
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Data',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Catalyst by the Numbers',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.charts'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'CCV4 Votes',
                'route_type' => 'route_name',
                'route' => 'projectCatalyst.votes.ccv4'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Catalyst Api',
                'route_type' => 'url',
                'route' => '/catalyst-explorer/api'
            ]),
        ],
    ]),
    new \Illuminate\Support\Fluent([
        'title' => 'Tools',
        'items' => [
            new Illuminate\Support\Fluent([
                'title' => 'Voter Tool',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.voter-tool'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Check my registration',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.registrations'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'Check my vote',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.my-votes'
            ]),
            new Illuminate\Support\Fluent([
                'title' => 'My Bookmarks',
                'route_type' => 'route_name',
                'route' => 'catalyst-explorer.myBookmarks'
            ]),
        ],
    ]),
];

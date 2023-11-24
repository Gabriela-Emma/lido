<?php

return [
    new Illuminate\Support\Fluent([
        'title' => 'Home',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.home',
        'navigate' => 'livewire',
    ]),
    new Illuminate\Support\Fluent([
        'title' => 'Proposals',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.proposals',
        'navigate' => 'livewire',
    ]),
    new Illuminate\Support\Fluent([
        'title' => 'People',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.people.index',
        'navigate' => 'livewire',
    ]),
    new Illuminate\Support\Fluent([
        'title' => 'Charts',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.charts',
        'navigate' => 'livewire',
    ]),
    new Illuminate\Support\Fluent([
        'title' => 'Voter Tool',
        'route_type' => 'route_name',
        'route' => 'catalyst-explorer.voter-tool',
        'navigate' => 'livewire',
    ]),
];

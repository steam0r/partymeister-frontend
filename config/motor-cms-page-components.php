<?php

return [
    'groups'     => [
        'partymeister' => [
            'name' => 'Partymeister'
        ]
    ],
    'components' => [
        'item-list' => [
            'name'            => 'Item list',
            'description'     => 'Show item list',
            'view'            => 'partymeister-frontend::frontend.component.partymeister.item-list',
            'component_class' => 'Partymeister\Frontend\Components\Partymeister\ItemList',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'partymeister'
        ],
        'schedule' => [
            'name'            => 'Schedule',
            'description'     => 'Show schedule',
            'route'           => 'component.schedules',
            'view'            => 'partymeister-frontend::frontend.component.partymeister.schedule',
            'component_class' => 'Partymeister\Frontend\Components\Partymeister\Schedule',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'partymeister'
        ],
    ],
];

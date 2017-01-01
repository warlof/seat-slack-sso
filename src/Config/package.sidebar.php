<?php

return [
    'slacksso' => [
        'name' => 'Slack SSO Authentication',
        'icon' => 'fa-slack',
        'route_segment' => 'slacksso',
        'permission' => 'slacksso.setup',
        'entries' => [
            [
                'name' => 'Settings',
                'icon' => 'fa-cogs',
                'route' => 'warlof.slack.sso.configuration',
                'permission' => 'slacksso.setup'
            ]
        ]
    ]
];

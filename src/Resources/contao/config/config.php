<?php declare(strict_types=1);

use lindesbs\MemberDisplay\FrontendModule\MemberDisplayModule;

$GLOBALS['FE_MOD']['user']['MemberDisplay'] = MemberDisplayModule::class;

$GLOBALS['BE_MOD'] = [
    'MemberDisplay' => [
        'page' => [
            'tables' => ['tl_memberdisplay'],
        ]
    ]
];

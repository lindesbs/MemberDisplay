<?php

declare(strict_types=1);

use lindesbs\MemberDisplay\Classes\DCABackendClasses;
use lindesbs\MemberDisplay\EventListener\MemberDisplayBackend;

$GLOBALS['TL_DCA']['tl_content']['palettes']['display_single_member'] =
    '{type_legend},type;memberdisplay_layout,memberdisplay_member;';



DCABackendClasses::createDcaField(
    'tl_content',
    'memberdisplay_layout',
    [
        'inputType' => 'select',
        'foreignKey' => 'tl_memberdisplay_layout.name',
        'eval' => ['includeBlankOption' => true, 'chosen' => true,'tl_class' => 'w50']
    ]
);

DCABackendClasses::createDcaField(
    'tl_content',
    'memberdisplay_member',
    [
        'inputType' => 'select',
        'options' => MemberDisplayBackend::getMemberForDisplay(),
        'eval' => ['includeBlankOption' => true, 'chosen' => true,'tl_class' => 'w50', 'required' => true]
    ]
);

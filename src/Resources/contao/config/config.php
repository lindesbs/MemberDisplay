<?php
declare(strict_types=1);

use lindesbs\MemberDisplay\Models\MemberAddressModel;
use lindesbs\MemberDisplay\Models\MemberDisplayLayoutModel;
use lindesbs\MemberDisplay\Widget\AddressListWidget;

$GLOBALS['BE_MOD']['layout']['memberdisplay'] = [
    'tables' => ['tl_memberdisplay_layout'],
    'icon' => 'bundles/memberdisplay/icon.svg'
];

$GLOBALS['BE_MOD']['accounts']['member']['tables'][] = 'tl_member_address';

$GLOBALS['BE_FFL']['addressList'] = AddressListWidget::class;

// Models
$GLOBALS['TL_MODELS']['tl_member_address'] = MemberAddressModel::class;
$GLOBALS['TL_MODELS']['tl_memberdisplay_layout'] = MemberDisplayLayoutModel::class;


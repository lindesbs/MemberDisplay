<?php


declare(strict_types=1);

use lindesbs\MemberDisplay\Controller\Page\QRCodePage;
use lindesbs\MemberDisplay\Controller\Page\VCardPage;

$GLOABLS['TL_LANG']['tl_page']['palettes'][QRCodePage::TYPE] = '{title_legend},title,type;{routing_legend},alias';
$GLOABLS['TL_LANG']['tl_page']['palettes'][VCardPage::TYPE] = '{title_legend},title,type;{routing_legend},alias';

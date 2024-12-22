<?php


declare(strict_types=1);

namespace lindesbs\MemberDisplay\EventListener;

use Contao\Backend;
use Contao\MemberModel;
use Contao\System;

class MemberDisplayBackend extends Backend
{

    const TYPE_LOGGEDIN = 'loggedin';
    public static function getMemberForDisplay()
    {
        System::loadLanguageFile('tl_content');

        $objMember = MemberModel::findAll();
        $arrMember = [];
        $arrMember['loggedin'][self::TYPE_LOGGEDIN] = $GLOBALS['TL_LANG']['tl_content']['memberdisplay_member_loggedin'];

        foreach ($objMember as $member) {
            if (!$member->disable) {
                $arrMember['member'][$member->id] = sprintf("%s %s, %s", $member->firstname, $member->lastname, $member->birthday);
            }
        }

        return $arrMember;
    }
}

<?php


declare(strict_types=1);

namespace lindesbs\MemberDisplay\EventListener;


use Contao\Backend;
use Contao\MemberModel;

class MemberDisplayBackend extends Backend
{

    public static function getMember()
    {
        $objMember = MemberModel::findAll();
        $arrMember = [];

        foreach ($objMember as $member) {
            if (!$member->disable) {
                $arrMember[] = sprintf("%s %s, %s", $member->firstname, $member->lastname, $member->birthday);
            }
        }
        return $arrMember;
    }
}

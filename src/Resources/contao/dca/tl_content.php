<?php

declare(strict_types=1);

use Contao\Backend;
use Contao\MemberModel;
use lindesbs\MemberDisplay\ContentElement\DisplaySingleMemberController;

$GLOBALS['TL_DCA']['tl_content']['palettes']['display_single_member'] = '
    {type_legend},type,memberdisplay_layout,memberdisplay_member;
';


$GLOBALS['TL_DCA']['tl_content']['fields']['memberdisplay_layout'] = ['label' => &$GLOBALS['TL_LANG']['tl_content']['memberdisplay_layout'], 'exclude' => true, 'input' => 'select', 'options' => 'tl_memberdisplay_layout.name', 'eval' => ['includeBlankOption' => true, 'require' => true], 'sql' => "varchar(255) NOT NULL default ''"];
$GLOBALS['TL_DCA']['tl_content']['fields']['memberdisplay_member'] = ['label' => &$GLOBALS['TL_LANG']['tl_content']['member'], 'exclude' => true, 'input' => 'select', 'options_callback' => MemberDisplayBackend::getMember(...), 'eval' => ['includeBlankOption' => true, 'required' => true], 'sql' => "varchar(255) NOT NULL default ''"];

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

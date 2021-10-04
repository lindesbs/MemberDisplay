<?php

namespace lindesbs\MemberDisplay\DCA;

use Contao\Backend;
use Contao\BackendUser;
use Contao\DataContainer;

class ModuleTools extends Backend
{
    public function __construct()
    {
        parent::__construct();
        $this->import(BackendUser::class, 'User');
    }

    public function getTitle(DataContainer $dc)
    {
        $arrModules=[];
        $objModules = $this->Database->execute("SELECT id,firstname,lastname,company FROM tl_member WHERE disable!=1 ORDER BY firstname");

        while ($objModules->next())
        {
            $name = trim($objModules->firstname.' '.$objModules->lastname);

            if ($objModules->company) {
                $name.=", ".$objModules->company;
            }

            $arrModules[$objModules->id] = $name;
        }

        return $arrModules;
    }
}
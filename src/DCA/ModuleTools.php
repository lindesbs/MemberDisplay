<?php

declare(strict_types=1);

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

    public function getTitle(DataContainer $dataContainer)
    {
        $arrModules = [];
        $result = $this->Database->execute("SELECT id,firstname,lastname,company FROM tl_member WHERE disable!=1 ORDER BY firstname");

        while ($result->next()) {
            $name = trim($result->firstname . ' ' . $result->lastname);

            if ($result->company) {
                $name .= ", " . $result->company;
            }

            $arrModules[$result->id] = $name;
        }

        return $arrModules;
    }
}

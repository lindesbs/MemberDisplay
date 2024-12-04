<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\Classes;

use Contao\Backend;
use Contao\DataContainer;
use lindesbs\MemberDisplay\Models\MemberAddressModel;

class TlMemberCallbacks extends Backend
{
    public function ensureDefaultAddress(DataContainer $dc): void
    {
        // Check if we are editing a specific record
        if (!$dc->id) {
            return;
        }

        $objAddress = MemberAddressModel::findByPk($dc->id);

        if ($objAddress) {
            return;
        }


        $objAddress = new MemberAddressModel();
        $objAddress->pid = $dc->id;

        $objAddress->save();
    }
}


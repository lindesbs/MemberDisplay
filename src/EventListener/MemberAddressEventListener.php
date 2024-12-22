<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use lindesbs\MemberDisplay\Constants\AkademischeTitel;
use lindesbs\MemberDisplay\Models\MemberAddressModel;

#[AsCallback(table: 'tl_member_address', target: 'config.onsubmit')]
class MemberAddressEventListener
{
    public function __invoke(DataContainer $dc): void
    {
        if ($dc->activeRecord->name == '') {
            $newName = trim(sprintf(
                "%s %s %s",
                AkademischeTitel::$arrTitel[$dc->activeRecord->titel],
                $dc->activeRecord->vorname,
                $dc->activeRecord->nachname
            ));


            $objMemberAddress = MemberAddressModel::findById($dc->activeRecord->id);
            if ($objMemberAddress !== null) {
                $objMemberAddress->name = $newName;
                $objMemberAddress->save();
            } else {
                // Fehlerbehandlung: Kein MemberAddress gefunden
                throw new \RuntimeException(sprintf(
                    'No MemberAddress found for ID %d',
                    $dc->activeRecord->id
                ));
            }

            $objMemberAddress->save();
        }
    }
}

<?php

namespace lindesbs\MemberDisplay\Widget;

use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;
use Contao\Widget;

class AddressListWidget extends Widget
{
    protected $blnSubmitInput = false; // Keine direkte Eingabe erforderlich
    protected $strTemplate = 'be_widget';

    /**
     * Generate the widget
     *
     * @return string
     */
    public function generate(): string
    {
        // Hole die ID des aktuellen Datensatzes
        $dc = $this->objDca;
        $parentId = $dc->activeRecord->id;

        // Lade die Adressen aus der tl_member_address-Tabelle
        $addresses = Database::getInstance()
            ->prepare("SELECT * FROM tl_member_address WHERE pid=?")
            ->execute($parentId);

        if (!$addresses->numRows) {
            return '<p>No addresses added yet.</p>';
        }

        // Generiere eine Liste der Adressen
        $output = '<ul>';
        while ($addresses->next()) {
            $addAddressUrl = Backend::addToUrl(
                sprintf('act=edit&table=tl_member_address&pid=%d', $addresses->id)
            );

            $output .= sprintf(
                '<li>%s, %s, %s %s (%s) %s</li>',
                $addresses->name,
                $addresses->street,
                $addresses->postal,
                $addresses->city,
                $addresses->country,
                sprintf(
                    '<p><a href="%s" class="tl_submit">Edit</a></p>',
                    $addAddressUrl
                )
            );
        }
        $output .= '</ul>';

        // Link, um neue Adressen hinzuzufügen
        $addAddressUrl = Backend::addToUrl(
            sprintf('act=create&table=tl_member_address&pid=%d', $parentId)
        );
        $output .= sprintf(
            '<p><a href="%s" class="tl_submit">Add new address</a></p>',
            $addAddressUrl
        );

        return $output;
    }
}

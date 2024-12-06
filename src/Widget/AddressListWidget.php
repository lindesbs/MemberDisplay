<?php

namespace lindesbs\MemberDisplay\Widget;

use Contao\Backend;
use Contao\BackendTemplate;
use Contao\Database;
use Contao\DataContainer;
use Contao\Widget;
use lindesbs\MemberDisplay\Models\MemberAddressModel;

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
        $GLOBALS['TL_CSS']['be_widget_itemlist'] =
            \Contao\Template::generateStyleTag('bundles/memberdisplay/be_widget_itemlist.css');

        $dc = $this->objDca;
        $parentId = $dc->activeRecord->id;


        $template = new BackendTemplate('be_addresslist_widget');

        $addresses = MemberAddressModel::findByPk($parentId);

        // URLs für Bearbeiten und Löschen erstellen
        $editUrl = 'contao?do=member&table=tl_member_address&amp;act=edit';
        $deleteUrl = 'contao?do=member&table=tl_member_address&amp;act=delete';

        $template->addresses = $addresses;
        $template->editUrl = $editUrl;
        $template->deleteUrl = $deleteUrl;

        return $template->parse();
    }
}

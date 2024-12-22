<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\Widget;

use Contao\BackendTemplate;
use Contao\Widget;
use lindesbs\MemberDisplay\Models\MemberAddressModel;

class AddressListWidget extends Widget
{
    protected $blnSubmitInput = false;

    // Keine direkte Eingabe erforderlich
    protected $strTemplate = 'be_widget';

    /**
     * Generate the widget
     */
    #[\Override]
    public function generate(): string
    {

        echo "**";
        $GLOBALS['TL_CSS']['be_widget_itemlist'] =
            \Contao\Template::generateStyleTag('bundles/memberdisplay/be_widget_itemlist.css');

        $dc = $this->objDca;
        $parentId = $dc->activeRecord->id;


        $template = new BackendTemplate('be_addresslist_widget');

        $addresses = MemberAddressModel::findByPk($parentId);
        $editUrl = 'contao?do=member&table=tl_member_address&amp;act=edit';

        $template->addresses = $addresses;
        $template->editUrl = $editUrl;

        return $template->parse();
    }
}

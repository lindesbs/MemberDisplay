<?php

declare(strict_types=1);

use Contao\DataContainer;

use Contao\Controller;

use Contao\DC_Table;
use Contao\Config;

$GLOBALS['TL_DCA']['tl_memberdisplay_layout'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => false,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    'list' => ['sorting' => ['mode' => DataContainer::MODE_SORTABLE, 'fields' => ['name'], 'panelLayout' => 'filter;search,limit'], 'label' => [

  			'fields'                  => ['name', 'template'],
  			'format'                  => '%s <span class="label-info">[%s]</span>',
          ]],
    // Palettes
    'palettes' => ['__selector__' => ['generateVCard','generateQRCode'], 'default' => '{title_legend},name;{layout_legend},template,memberImage,cssClass;{vcard_legend},generateVCard;{qrcode_legend},generateQRCode;{enclosure_legend:hide},addEnclosure;{publish_legend},published'],


    // Sub-palettes
    'subpalettes' => [
        'generateVCard' => 'vcardText,vcardLink',
        'generateQRCode' => 'qrCodeType'
    ],

    // Fields
    'fields' => [

        'id' => ['sql' => "int(10) unsigned NOT NULL auto_increment"],
        'pid' => ['foreignKey' => 'tl_memberdisplay_layout.title', 'sql' => "int(10) unsigned NOT NULL default 0", 'relation' => ['type' => 'belongsTo', 'load' => 'lazy']],
        'sorting' => ['sql' => "int(10) unsigned NOT NULL default 0"],
        'tstamp' => ['sql' => "int(10) unsigned NOT NULL default 0"],
        'name' => [

            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['name'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50', 'maxlength' => 255],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'template' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['template'],
            'exclude' => true,
            'inputType' => 'select',
            'options_callback' => ['DCABackendClasses', 'getTemplates'],
            'eval' => ['tl_class' => 'w50', 'includeBlankOption'=>true],
            'sql' => "varchar(64) NOT NULL default ''"
        ],
        'memberImage' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['memberImage'],
            'exclude' => true,
            'inputType' => 'fileTree',
            'eval' => [
                'filesOnly' => true,
                'extensions' => Config::get('validImageTypes'),
                'fieldType' => 'radio',
                'tl_class' => 'clr'
            ],
            'sql' => "binary(16) NULL"
        ],
        'cssClass' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['cssClass'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'generateVCard' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['generateVCard'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => '', 'submitOnChange' => true],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'generateQRCode' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['generateQRCode'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => '', 'submitOnChange' => true],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'vcardText' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['vcardText'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'sql' => "char(1) NOT NULL default ''"
        ],
        'vcardLink' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['vcardLink'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'sql' => "char(1) NOT NULL default ''"
        ],
        'qrCodeType' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['qrCodeType'],
            'exclude' => true,
            'inputType' => 'select',
            'options' => ['full_data', 'vcard_link'],
            'reference' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['qrCodeType_options'],
            'eval' => ['tl_class' => 'w50'],
            'sql' => "varchar(32) NOT NULL default 'full_data'"
        ],
    ]
];



class DCABackendClasses
{
    public function getTemplates(DataContainer $dc)
    {
        return Controller::getTemplateGroup('ce_display_single_member_');
    }
}

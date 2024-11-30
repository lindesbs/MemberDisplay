<?php

use Contao\DataContainer;
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
    'list' => array
    (
        'sorting' => array
        (
            'mode' => DataContainer::MODE_SORTABLE,
            'fields' => array('name'),
            'panelLayout' => 'filter;search,limit',
            'renderAsGrid' => true,
            'limitHeight' => 160
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__' => ['generateVCard'],
        'default' => '{title_legend},title,name;{layout_legend},template,memberImage,cssClass;{vcard_legend},generateVCard;{enclosure_legend:hide},addEnclosure;{publish_legend},published'
    ),


    // Sub-palettes
    'subpalettes' => ['generateVCard' => 'vcardText,vcardLink,qrCodeType'],

    // Fields
    'fields' => [
        
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'foreignKey' => 'tl_memberdisplay_layout.title',
            'sql' => "int(10) unsigned NOT NULL default 0",
            'relation' => array('type' => 'belongsTo', 'load' => 'lazy')
        ),
        'sorting' => array
        (
            'sql' => "int(10) unsigned NOT NULL default 0"
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default 0"
        ),
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
            'eval' => ['tl_class' => 'w50 m12', 'submitOnChange' => true],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'vcardText' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['vcardText'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50', 'maxlength' => 255],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'vcardLink' => [
            'label' => &$GLOBALS['TL_LANG']['tl_memberdisplay_layout']['vcardLink'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50', 'rgxp'=>'url'],
            'sql' => "varchar(255) NOT NULL default ''"
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

<?php

declare(strict_types=1);

use Contao\DataContainer;
use lindesbs\MemberDisplay\Classes\BackendDCAMemberDisplay;
use lindesbs\MemberDisplay\Classes\DCABackendClasses;
use lindesbs\MemberDisplay\EventListener\MemberAddressEventListener;

$GLOBALS['TL_DCA']['tl_member_address'] = [
    'config' => [
        'dataContainer' => \Contao\DC_Table::class,
        'ptable' => 'tl_member',
        'enableVersioning' => false,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid' => 'index',
            ],
        ],
        'onsubmit_callback' => [
            [MemberAddressEventListener::class, '__invoke'],
        ]
    ],
    'list' => [
        'sorting' => [
            'mode' => DataContainer::MODE_PARENT,
            'fields' => ['street'],
            'headerFields' => ['firstname', 'lastname'],
            'flag' => 1,
            'panelLayout' => 'filter;search,sort,limit',
            'child_record_callback' => [BackendDCAMemberDisplay::class, 'listAddressRecords'],
        ],
        'label' => [
            'fields' => ['street', 'city'],
            'format' => '%s, %s',
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()"',
            ],
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_member_address']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_member_address']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'data-action="contao--scroll-offset#store" onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirmFile'] ?? null) . '\'))return false"',

            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_member_address']['show'],
                'href' => 'act=show',
                'icon' => 'show.svg',
            ],
        ],
    ],
    'palettes' => [
        '__selector__' => [],
        'default' => "{legend_memberdisplay},adressType,name,vorname,nachname,zsichenteil,titel,alternativeNamen,".
            "kuenstlernamen,nickname;{address_legend},strasse,hausnummer,etage,plz,ort,land;kurzbeschreibung,".
            "geburtsdatum,geburtsort,homepage,email,telefon,bevorzugteKontaktart,geschlecht;".
            "familiaereBeziehung,duplikatVon",
    ],
    'subpalettes' => [],
    'fields' => [

        'id' => ['sql' => "int(10) unsigned NOT NULL auto_increment"],
        'pid' => ['foreignKey' => 'tl_memberdisplay_layout.title', 'sql' => "int(10) unsigned NOT NULL default 0", 'relation' => ['type' => 'belongsTo', 'load' => 'lazy']],
        'sorting' => ['sql' => "int(10) unsigned NOT NULL default 0"],
        'tstamp' => ['sql' => "int(10) unsigned NOT NULL default 0"],

    ]
];



// Beispiel für die Verwendung der Funktion
DCABackendClasses::createDcaField('tl_member_address', 'addressType', [
    'inputType' => 'select',
    'options' => ['privat', 'hobby', 'beruflich'],
    'eval' => ['includeBlankOption' => true, 'mandatory' => false],
]);

DCABackendClasses::createDcaField('tl_member_address', 'name', $evalConfig = ['tl_class' => 'w50 clr']);
DCABackendClasses::createDcaField('tl_member_address', 'vorname', $evalConfig = ['tl_class' => 'w50 clr']);

DCABackendClasses::createDcaField('tl_member_address', 'nachname', []);
DCABackendClasses::createDcaField('tl_member_address', 'language', $evalConfig = ['tl_class' => 'w50']);
DCABackendClasses::createDcaField('tl_member_address', 'zwischenteil', []);
DCABackendClasses::createDcaField('tl_member_address', 'titel', [
    'inputType' => 'select',
    'options' => lindesbs\MemberDisplay\Constants\AkademischeTitel::$arrTitel,
    'eval' => ['includeBlankOption' => true, 'chosen' => true,'tl_class' => 'w25']
        ]

);

DCABackendClasses::createDcaField('tl_member_address', 'alternativeNamen', []);
DCABackendClasses::createDcaField('tl_member_address', 'kurzbeschreibung', [
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'rte' => 'tinyMCE'],
]);

DCABackendClasses::createDcaField('tl_member_address', 'geburtsdatum', [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'date', 'datepicker' => true],
],
    $evalConfig = ['tl_class' => 'w25']);

DCABackendClasses::createDcaField('tl_member_address', 'geburtsort', [],
    $evalConfig = ['tl_class' => 'w25']);
DCABackendClasses::createDcaField('tl_member_address', 'kuenstlernamen', []);
DCABackendClasses::createDcaField('tl_member_address', 'nickname', []);
DCABackendClasses::createDcaField('tl_member_address', 'homepage', []);
DCABackendClasses::createDcaField('tl_member_address', 'email', [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'email', 'maxlength' => 255],
]);

DCABackendClasses::createDcaField('tl_member_address', 'telefon', [
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'number' => [
                'inputType' => 'text',
                'eval' => ['rgxp' => 'phone'],
            ],
            'type' => [
                'inputType' => 'select',
                'options' => ['mobil', 'direkt', 'pager'],
            ],
        ],
    ],
]);

DCABackendClasses::createDcaField('tl_member_address', 'bevorzugteKontaktart', [
    'inputType' => 'select',
    'options' => ['Telefon', 'email', 'direkt'],
    'eval' => ['includeBlankOption' => true],
]);

DCABackendClasses::createDcaField('tl_member_address', 'geschlecht', [
    'inputType' => 'select',
    'options' => ['männlich', 'weiblich', 'divers'],
    'eval' => ['includeBlankOption' => true],
]);

DCABackendClasses::createDcaField('tl_member_address', 'familiaereBeziehung', [
    'inputType' => 'select',
    'foreignKey' => 'tl_member_address.id',
    'eval' => ['mandatory' => false,'includeBlankOption' => true,'tl_class' => 'w25'],
]);

DCABackendClasses::createDcaField('tl_member_address', 'duplikatVon', [
    'inputType' => 'select',
    'foreignKey' => 'tl_member_address.id',
    'eval' => ['mandatory' => false,'includeBlankOption' => true,'tl_class' => 'w25'],
]);

DCABackendClasses::createDcaField('tl_member_address', 'strasse', []);
DCABackendClasses::createDcaField('tl_member_address', 'hausnummer', []);
DCABackendClasses::createDcaField('tl_member_address', 'etage', []);
DCABackendClasses::createDcaField('tl_member_address', 'plz', []);
DCABackendClasses::createDcaField('tl_member_address', 'ort', []);
DCABackendClasses::createDcaField('tl_member_address', 'land', []);


foreach (BackendDCAMemberDisplay::$fieldsWithDefaults as $field => $sourceField) {
    $GLOBALS['TL_DCA']['tl_member_address']['fields'][$field]['load_callback'][] = [BackendDCAMemberDisplay::class, 'setDefaultFromSource'];
}


<?php

declare(strict_types=1);


use Contao\DataContainer;
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


function createDcaField(string $dca, string $fieldName, array $config = [], array $evalConfig = [], string $inputType = "text"): void
{
    $defaultConfig = [
        'label' => $GLOBALS['TL_LANG'][$dca][$fieldName] ?? ['###', '###'],
        'inputType' => $inputType,
        'eval' => [],
        'sql' => '',
    ];

    // Automatische SQL-Typen basierend auf dem inputType
    if (!isset($config['sql']) || $config['sql'] === '') {
        $sqlMapping = [
            'text' => "varchar(255) NOT NULL default ''",
            'textarea' => "text NULL",
            'select' => "varchar(64) NOT NULL default ''",
            'checkbox' => "char(1) NOT NULL default ''",
            'radio' => "varchar(32) NOT NULL default ''",
            'multiColumnWizard' => "text NULL",
            'fileTree' => "blob NULL",
        ];

        $inputType = $config['inputType'] ?? $defaultConfig['inputType'];
        $config['sql'] = $sqlMapping[$inputType] ?? $sqlMapping['text'];
    }

    // Standard-eval-Einstellungen basierend auf dem inputType
    if (!isset($config['eval']) || empty($config['eval'])) {
        $evalMapping = [
            'text' => ['mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'],
            'textarea' => ['mandatory' => false, 'rte' => 'tinyMCE'],
            'select' => ['mandatory' => false, 'includeBlankOption' => true],
            'checkbox' => ['mandatory' => false, 'tl_class' => 'w50'],
            'radio' => ['mandatory' => false, 'tl_class' => 'w50'],
            'multiColumnWizard' => ['mandatory' => false],
            'fileTree' => ['mandatory' => false, 'filesOnly' => true, 'fieldType' => 'radio', 'extensions' => Contao\Config::get('validImageTypes')],
        ];

        $config['eval'] = $evalMapping[$inputType] ?? $evalMapping['text'];
    }

    $config['eval'] = array_merge($config['eval'], $evalConfig);
    $GLOBALS['TL_DCA'][$dca]['fields'][$fieldName] = array_merge($defaultConfig, $config);
}


// Beispiel für die Verwendung der Funktion
createDcaField('tl_member_address', 'addressType', [
    'inputType' => 'select',
    'options' => ['privat', 'hobby', 'beruflich'],
    'eval' => ['includeBlankOption' => true, 'mandatory' => false],
]);

createDcaField('tl_member_address', 'name', $evalConfig = ['tl_class' => 'w50 clr']);
createDcaField('tl_member_address', 'vorname', $evalConfig = ['tl_class' => 'w50 clr']);

createDcaField('tl_member_address', 'nachname', []);
createDcaField('tl_member_address', 'language', $evalConfig = ['tl_class' => 'w50']);
createDcaField('tl_member_address', 'zwischenteil', []);
createDcaField('tl_member_address', 'titel', [
    'inputType' => 'select',
    'options' => lindesbs\MemberDisplay\Constants\AkademischeTitel::$arrTitel,
    'eval' => ['includeBlankOption' => true, 'chosen' => true,'tl_class' => 'w25']
        ]

);

createDcaField('tl_member_address', 'alternativeNamen', []);
createDcaField('tl_member_address', 'kurzbeschreibung', [
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'rte' => 'tinyMCE'],
]);

createDcaField('tl_member_address', 'geburtsdatum', [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'date', 'datepicker' => true],
],
    $evalConfig = ['tl_class' => 'w25']);

createDcaField('tl_member_address', 'geburtsort', [],
    $evalConfig = ['tl_class' => 'w25']);
createDcaField('tl_member_address', 'kuenstlernamen', []);
createDcaField('tl_member_address', 'nickname', []);
createDcaField('tl_member_address', 'homepage', []);
createDcaField('tl_member_address', 'email', [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'email', 'maxlength' => 255],
]);

createDcaField('tl_member_address', 'telefon', [
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

createDcaField('tl_member_address', 'bevorzugteKontaktart', [
    'inputType' => 'select',
    'options' => ['Telefon', 'email', 'direkt'],
    'eval' => ['includeBlankOption' => true],
]);

createDcaField('tl_member_address', 'geschlecht', [
    'inputType' => 'select',
    'options' => ['männlich', 'weiblich', 'divers'],
    'eval' => ['includeBlankOption' => true],
]);

createDcaField('tl_member_address', 'familiaereBeziehung', [
    'inputType' => 'select',
    'foreignKey' => 'tl_member_address.id',
    'eval' => ['mandatory' => false,'includeBlankOption' => true,'tl_class' => 'w25'],
]);

createDcaField('tl_member_address', 'duplikatVon', [
    'inputType' => 'select',
    'foreignKey' => 'tl_member_address.id',
    'eval' => ['mandatory' => false,'includeBlankOption' => true,'tl_class' => 'w25'],
]);

createDcaField('tl_member_address', 'strasse', []);
createDcaField('tl_member_address', 'hausnummer', []);
createDcaField('tl_member_address', 'etage', []);
createDcaField('tl_member_address', 'plz', []);
createDcaField('tl_member_address', 'ort', []);
createDcaField('tl_member_address', 'land', []);


foreach (BackendDCAMemberDisplay::$fieldsWithDefaults as $field => $sourceField) {
    $GLOBALS['TL_DCA']['tl_member_address']['fields'][$field]['load_callback'][] = [BackendDCAMemberDisplay::class, 'setDefaultFromSource'];
}


class BackendDCAMemberDisplay
{
    public static $fieldsWithDefaults = [
        'vorname' => 'firstname',
        'nachname' => 'lastname',
        'language' => 'language',
        'geburtsdatum' => 'dateOfBirth',
        'geschlecht' => 'gender',
        'company' => 'company',
        'strasse' => 'street',
        'plz' => 'postal',
        'ort' => 'city',
        'bundesland' => 'state',
        'land' => 'country',
        'telefon' => 'phone',
        'mobil' => 'mobile',
        'email' => 'email',
        'website' => 'website',
        'fax' => 'fax',
    ];

    /**
     * Setzt den Wert eines Feldes basierend auf dem Wert eines anderen Feldes
     *
     * @param mixed $varValue Der aktuelle Wert des Feldes
     * @param DataContainer $dc Der Datencontainer
     *
     * @return mixed Der neue Wert des Feldes
     */
    public function setDefaultFromSource($varValue, DataContainer $dc)
    {
        $sourceField = $this->getSourceField($dc->field);
        $objMember = \Contao\MemberModel::findById($dc->activeRecord->pid);


        if (empty($varValue) && isset($objMember->$sourceField) && !empty($objMember->$sourceField)) {
            return $objMember->$sourceField;
        }

        return $varValue;
    }


    private function getSourceField($fieldName)
    {
        return self::$fieldsWithDefaults[$fieldName] ?? null;
    }


    public function listAddressRecords(array $row): string
    {
        return sprintf('%s<br>%s, %s %s', $row['name'], $row['street'], $row['postal'], $row['city']);
    }
}

<?php

declare(strict_types=1);

use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] .= ";{legend_memberdisplay},adressType,name,vorname,nachname,zsichenteil,titel,alternativeNamen,kurzbeschreibung,geburtsdatum,geburtsort,kuenstlernamen,nickname,homepage,email,telefon,bevorzugteKontaktart,geschlecht,familiäreBeziehung,duplikatVon;{address_legend},strasse,hausnummer,etage,plz,ort,land;";

function createDcaField(string $dca, string $fieldName, array $config = [], array $evalConfig=[], string $inputType = "text"): void
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

    $config = array_merge($config['eval'], $evalConfig);

    $GLOBALS['TL_DCA'][$dca]['fields'][$fieldName] = array_merge($defaultConfig, $config);
}


/*
 * AdressType (privat, hobby, beruflich)
 * Name
 * Vorname
 * Nachname
 * Zsichenteil
 * Titel (Dr., Prof. etc)
 * Alternative Namen
 * Kurzbeschreibung
 * Geburtsdatum
 * Geburtsort
 * Künstlernamen
 * Nickname
 * homepage
 * email
 * Telefon (mehrere moeglich, Inkl Typus (mobil, direkt, Pager)
 * bevorzugte Kontaktart (Telefon, email, direkt)
 * Geschlecht
 * Familiäre Beziehung (Vater, Sohn, Bruder, etc) -> Verknuepfung zu tl_member.id
 * Duplikat von (Vater, Sohn, Bruder, etc) -> Verknuepfung zu tl_member.id
 * Strasse
 * Hausnummer
 * Etage
 * PLZ
 * Ort
 * Land
 *
 *
 *
 *
 */

// Beispiel für die Verwendung der Funktion
createDcaField('tl_member', 'adressType', [
    'inputType' => 'select',
    'options' => ['privat', 'hobby', 'beruflich'],
    'eval' => ['includeBlankOption' => true, 'mandatory' => false],
]);

createDcaField('tl_member', 'name', []);
createDcaField('tl_member', 'vorname', []);

createDcaField('tl_member', 'nachname', []);
createDcaField('tl_member', 'language', []);
createDcaField('tl_member', 'zwischenteil', []);
createDcaField('tl_member', 'titel', [
    'inputType' => 'select',
    'options' => ['Dr.', 'Prof.', 'Dr. Prof.', 'keiner'],
    'eval' => ['includeBlankOption' => true],
]);

createDcaField('tl_member', 'alternativeNamen', []);
createDcaField('tl_member', 'kurzbeschreibung', [
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'rte' => 'tinyMCE'],
]);

createDcaField('tl_member', 'geburtsdatum', [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'date', 'datepicker' => true],
]);

createDcaField('tl_member', 'geburtsort', []);
createDcaField('tl_member', 'kuenstlernamen', []);
createDcaField('tl_member', 'nickname', []);
createDcaField('tl_member', 'homepage', []);
createDcaField('tl_member', 'email', [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'email', 'maxlength' => 255],
]);

createDcaField('tl_member', 'telefon', [
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

createDcaField('tl_member', 'bevorzugteKontaktart', [
    'inputType' => 'select',
    'options' => ['Telefon', 'email', 'direkt'],
    'eval' => ['includeBlankOption' => true],
]);

createDcaField('tl_member', 'geschlecht', [
    'inputType' => 'select',
    'options' => ['männlich', 'weiblich', 'divers'],
    'eval' => ['includeBlankOption' => true],
]);

createDcaField('tl_member', 'familiaereBeziehung', [
    'inputType' => 'select',
    'foreignKey' => 'tl_member.id',
    'eval' => ['mandatory' => false],
]);

createDcaField('tl_member', 'duplikatVon', [
    'inputType' => 'select',
    'foreignKey' => 'tl_member.id',
    'eval' => ['mandatory' => false],
]);

createDcaField('tl_member', 'strasse', []);
createDcaField('tl_member', 'hausnummer', []);
createDcaField('tl_member', 'etage', []);
createDcaField('tl_member', 'plz', []);
createDcaField('tl_member', 'ort', []);
createDcaField('tl_member', 'land', []);





foreach (BackendDCAMemberDisplay::$fieldsWithDefaults as $field => $sourceField) {
    $GLOBALS['TL_DCA']['tl_member']['fields'][$field]['load_callback'][] = [BackendDCAMemberDisplay::class, 'setDefaultFromSource'];
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
     * @param mixed          $varValue Der aktuelle Wert des Feldes
     * @param DataContainer  $dc       Der Datencontainer
     *
     * @return mixed Der neue Wert des Feldes
     */
    public function setDefaultFromSource($varValue, DataContainer $dc)
    {
        // Hole die Quelle des aktuellen Feldes aus der Konfiguration
        $sourceField = $this->getSourceField($dc->field);

        // Überprüfen, ob das Feld leer ist und die Quelle gesetzt wurde
        if (empty($varValue) && isset($dc->activeRecord->$sourceField) && !empty($dc->activeRecord->$sourceField)) {
            return $dc->activeRecord->$sourceField;
        }

        return $varValue;
    }

    /**
     * Gibt das Quellfeld für ein bestimmtes Ziel-Feld zurück
     *
     * @param string $fieldName Der Name des aktuellen Feldes
     *
     * @return string|null Der Name des Quellfeldes oder null
     */
    private function getSourceField($fieldName)
    {

        return self::$fieldsWithDefaults[$fieldName] ?? null;
    }
}

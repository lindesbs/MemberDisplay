<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\Classes;

use Contao\DataContainer;

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

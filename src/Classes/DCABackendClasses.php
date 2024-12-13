<?php

namespace lindesbs\MemberDisplay\Classes;

use Contao\Backend;
use Contao\Config;
use Contao\Controller;
use Contao\DataContainer;

class DCABackendClasses extends Backend
{
    public function getTemplates(DataContainer $dc)
    {
        return Controller::getTemplateGroup('ce_display_single_member_');
    }



    static function createDcaField(string $dca, string $fieldName, array $config = [], array $evalConfig = [], string $inputType = "text"): void
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
                'fileTree' => ['mandatory' => false, 'filesOnly' => true, 'fieldType' => 'radio', 'extensions' => Config::get('validImageTypes')],
            ];

            $config['eval'] = $evalMapping[$inputType] ?? $evalMapping['text'];
        }

        $config['eval'] = array_merge($config['eval'], $evalConfig);
        $GLOBALS['TL_DCA'][$dca]['fields'][$fieldName] = array_merge($defaultConfig, $config);
    }

}

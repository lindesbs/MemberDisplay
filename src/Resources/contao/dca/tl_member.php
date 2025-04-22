<?php

declare(strict_types=1);

$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] .= ";{legend_memberdisplay},primaryimage,signatureimage,secondaryimages";

$GLOBALS['TL_DCA']['tl_member']['fields']['primaryimage'] = [
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => array(
        'filesOnly' => true,
        'fieldType' => 'radio',
        'tl_class' => 'clr',
        'extensions' => Contao\Config::get('validImageTypes')
    ),
    'sql' => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_member']['fields']['signatureimage'] = [
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => array(
        'filesOnly' => true,
        'fieldType' => 'radio',
        'tl_class' => 'clr',
        'extensions' => Contao\Config::get('validImageTypes')
    ),
    'sql' => "binary(16) NULL"
];


$GLOBALS['TL_DCA']['tl_member']['fields']['secondaryimages'] = [
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => array(
        'multiple' => true,
        'filesOnly' => true,
        'fieldType' => 'checkbox',
        'tl_class' => 'clr',
        'extensions' => Contao\Config::get('validImageTypes')
    ),
    'sql' => "blob NULL"
];


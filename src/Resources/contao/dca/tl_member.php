<?php

declare(strict_types=1);

use lindesbs\MemberDisplay\ContaoClasses\ContaoDCA;

$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] .= ";{legend_memberdisplay},primaryimage,signatureimage,secondaryimages";

$GLOBALS['TL_DCA']['tl_member']['fields']['primaryimage'] = [
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => ['filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'clr', 'extensions' => Contao\Config::get('validImageTypes')],
    'sql' => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_member']['fields']['signatureimage'] = [
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => ['filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'clr', 'extensions' => Contao\Config::get('validImageTypes')],
    'sql' => "binary(16) NULL"
];


$GLOBALS['TL_DCA']['tl_member']['fields']['secondaryimages'] = [
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => ['multiple' => true, 'filesOnly' => true, 'fieldType' => 'checkbox', 'tl_class' => 'clr', 'extensions' => Contao\Config::get('validImageTypes')],
    'sql' => "blob NULL"
];



//
//class tl_member
//{
//    private bool $use_private_adress;
//
//    private string $Zusatzname;
//}
//
//$appData = ContaoDCA::generate(tl_member::class);
//dump($appData);

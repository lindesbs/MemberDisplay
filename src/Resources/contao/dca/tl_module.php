<?php


use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_module']['palettes']['MemberDisplay'] .= 'name,type,mitarbeiter,customTpl,jumpTo;size,imagemargin,floating;{expert_legend:hide},guests,cssID;{memberdisplay_legend:show}';


// Extend default palette
//PaletteManipulator::create()
//    ->addLegend('feed_legend', 'modules_legend', PaletteManipulator::POSITION_BEFORE)
//    ->addField('mitarbeiter', 'calendarfeeds', PaletteManipulator::POSITION_BEFORE, 'feed_legend', PaletteManipulator::POSITION_PREPEND)
//    ->applyToPalette('default', 'tl_module');

// Extend fields
$GLOBALS['TL_DCA']['tl_module']['fields']['mitarbeiter'] = array
(
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['lindesbs\MemberDisplay\DCA\ModuleTools', 'getTitle'],
    'eval' => ['includeBlankOption' => true, 'tl_class' => 'w50', 'chosen' => true],
    'sql' => "int(10) NULL"
);



$GLOBALS['TL_DCA']['tl_module']['fields']['size'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['size'],
    'exclude' => true,
    'inputType' => 'imageSize',
    'reference' => &$GLOBALS['TL_LANG']['MSC'],
    'eval' => array('rgxp' => 'natural', 'includeBlankOption' => true, 'nospace' => true, 'helpwizard' => true, 'tl_class' => 'w50'),
    'options_callback' => static function () {
        return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
    },
    'sql' => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['imagemargin'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['imagemargin'],
    'exclude' => true,
    'inputType' => 'trbl',
    'options' => $GLOBALS['TL_CSS_UNITS'],
    'eval' => array('includeBlankOption' => true, 'tl_class' => 'w50 clr'),
    'sql' => "varchar(128) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['floating'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['floating'],
    'exclude'                 => true,
    'inputType'               => 'radioTable',
    'options'                 => array('above', 'left', 'right', 'below'),
    'eval'                    => array('cols'=>4, 'tl_class'=>'w50'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'sql'                     => "varchar(12) NOT NULL default 'above'"
];
<?php


use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_memberdisplay_layout'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => true,
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
            'mode' => DataContainer::MODE_PARENT,
            'fields' => array('sorting'),
            'panelLayout' => 'filter;search,limit',
            'defaultSearchField' => 'question',
            'headerFields' => array('title', 'headline', 'jumpTo', 'tstamp'),
            'child_record_callback' => array('tl_faq', 'listQuestions'),
            'renderAsGrid' => true,
            'limitHeight' => 160
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__' => ['addImage', 'addEnclosure', 'overwriteMeta'],
        'default' => '{title_legend},question,alias,author;{meta_legend},pageTitle,robots,description,serpPreview;{answer_legend},answer;{image_legend},addImage;{enclosure_legend:hide},addEnclosure;{publish_legend},published'
    ),

    // Sub-palettes
    'subpalettes' => array
    (),

    // Fields
    'fields' => array
    (
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
        ])


];

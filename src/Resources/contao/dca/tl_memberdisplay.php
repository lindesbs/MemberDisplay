<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\Resources\contao\dca;

use lindesbs\ContaoDCA\Attribute\DCAConfig;
use lindesbs\ContaoDCA\Attribute\DCAField;
use lindesbs\ContaoDCA\Contract\DCAAwareInterface;

#[DCAConfig(
    table: 'tl_news',
    config: [
        'dataContainer' => 'Table',
        'enableVersioning' => true,
    ],
    list: [
        'sorting' => [
            'mode' => 1,
            'fields' => ['headline'],
            'flag' => 1,
        ],
        'label' => [
            'fields' => ['headline', 'date'],
            'format' => '%s (%s)',
        ],
    ],
    palettes: [
        'default' => '{title_legend},headline,alias,author;{date_legend},date,time;{text_legend},teaser,text'
    ]
)]
class tl_memberdisplay implements DCAAwareInterface
{
    private int $id;

    #[DCAField(
        name: 'headline',
        inputType: 'text',
        eval: ['mandatory' => true, 'maxlength' => 255]
    )]
    private string $headline;

    #[DCAField(
        name: 'alias',
        inputType: 'alias',
        eval: ['doNotCopy' => true, 'unique' => true, 'maxlength' => 128]
    )]
    private string $alias;

    #[DCAField(
        name: 'author',
        inputType: 'select',
        foreignKey: 'tl_user.name',
        relation: ['type' => 'hasOne', 'load' => 'eager']
    )]
    private int $author;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    public function getHeadline(): string
    {
        return $this->headline;
    }

    public function setHeadline(string $headline): self
    {
        $this->headline = $headline;
        return $this;
    }

    public function getAuthor(): int
    {
        return $this->author;
    }

    public function setAuthor(int $author): self
    {
        $this->author = $author;
        return $this;
    }
}

<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\Resources\contao\dca;

use lindesbs\ContaoDCA\Attribute\DCAConfig;
use lindesbs\ContaoDCA\Attribute\DCAField;

#[DCAConfig(enableVersioning: false)]
class tl_memberdisplay
{
    private int $id;

    #[DCAField()]
    private string $headline;

    #[DCAField()]
    private string $alias;

    #[DCAField()]
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


echo "tl_memberdisplay".PHP_EOL;
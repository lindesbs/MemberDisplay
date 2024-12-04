<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use lindesbs\MemberDisplay\MemberDisplayBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    #[\Override]
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(MemberDisplayBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}

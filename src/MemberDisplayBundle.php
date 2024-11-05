<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay;

use lindesbs\MemberDisplay\DependencyInjection\MemberDisplayExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class MemberDisplayBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MemberDisplayExtension();
    }
}

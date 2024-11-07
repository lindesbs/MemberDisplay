<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MemberDisplayExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $containerBuilder): void
    {
        (new YamlFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../../config')))
            ->load('services.yml')
        ;
    }
}

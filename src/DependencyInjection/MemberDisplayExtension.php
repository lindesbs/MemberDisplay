<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\DependencyInjection;

use Contao\CoreBundle\DependencyInjection\Filesystem\ConfigureFilesystemInterface;
use Contao\CoreBundle\DependencyInjection\Filesystem\FilesystemConfiguration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MemberDisplayExtension extends Extension implements ConfigureFilesystemInterface
{
    /**
     * {@inheritdoc}
     */
    #[\Override]
    public function load(array $mergedConfig, ContainerBuilder $containerBuilder): void
    {
        $yamlFileLoader = new YamlFileLoader(
            $containerBuilder,
            new FileLocator(__DIR__ . '/../../config')
        );

        $yamlFileLoader->load('services.yml');
    }

    #[\Override]
    public function configureFilesystem(FilesystemConfiguration $config): void
    {
        $filesStorageName = 'vCards';
        $config
            ->mountLocalAdapter('vCards', 'vCards', 'files')
            ->addVirtualFilesystem($filesStorageName, 'vCards')
        ;

    }
}

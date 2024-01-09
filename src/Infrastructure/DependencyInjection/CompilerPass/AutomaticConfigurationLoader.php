<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Infrastructure\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class AutomaticConfigurationLoader extends AbstractCompilerPass
{
    public const TYPE = PassConfig::TYPE_BEFORE_OPTIMIZATION;
    public const PRIORITY = 500;

    public function process(ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../Resources/config'));

        $currentConfigurationLoader = $container->resolveEnvPlaceholders(
            $container->getParameter('rich_id_configuration.automatic_configuration_loader'),
            true
        );

        switch ($currentConfigurationLoader) {
            case 'after_migration_executed':
                $loader->load('services-automatic-configuration-after-migration-executed-loader.xml');
        }
    }
}

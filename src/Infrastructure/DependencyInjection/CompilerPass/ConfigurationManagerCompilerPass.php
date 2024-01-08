<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Infrastructure\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use RichId\ConfigurationBundle\Domain\Configuration\ConfigurationManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ConfigurationManagerCompilerPass extends AbstractCompilerPass
{
    public const TAG = 'rich_id_configuration';

    public function process(ContainerBuilder $container): void
    {
        $services = $this->getConfigurations($container);
        $definition = $container->findDefinition(ConfigurationManager::class);

        foreach ($services as $service) {
            $definition->addMethodCall('addService', [$service]);
        }
    }

    /** @return Reference[] */
    private function getConfigurations(ContainerBuilder $container): array
    {
        $references = self::getReferencesByTag($container, self::TAG);

        \usort(
            $references,
            static function (Reference $a, Reference $b): int {
                return strcmp(
                    self::getConfigurationVersionName($a),
                    self::getConfigurationVersionName($b)
                );
            }
        );

        return $references;
    }

    private static function getConfigurationVersionName(Reference $version): string
    {
        $exploded = explode('\\', (string) $version);

        return \end($exploded) ?: '';
    }
}

<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Infrastructure\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

class Configuration extends AbstractConfiguration
{
    public const CONFIG_NODE = 'rich_id_configuration';

    protected function buildConfiguration(ArrayNodeDefinition $rootNode): void
    {
        $children = $rootNode->children();

        $this->buildConfigurationNamespace($children);
        $this->buildConfigurationPath($children);
        $this->buildAutomaticConfigurationLoader($children);
    }

    protected function buildConfigurationNamespace(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->scalarNode('configuration_namespace')
            ->isRequired()
            ->defaultValue('Configurations')
            ->end();
    }

    protected function buildConfigurationPath(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->scalarNode('configuration_path')
            ->isRequired()
            ->defaultValue('%kernel.project_dir%/configurations')
            ->end();
    }

    protected function buildAutomaticConfigurationLoader(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->scalarNode('automatic_configuration_loader')
            ->defaultValue(null)
            ->end();
    }
}

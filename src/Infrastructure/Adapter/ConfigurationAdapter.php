<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Infrastructure\Adapter;

use RichId\ConfigurationBundle\Domain\Port\ConfigurationInterface;
use RichId\ConfigurationBundle\Infrastructure\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Service\Attribute\Required;

class ConfigurationAdapter implements ConfigurationInterface
{
    #[Required]
    public ParameterBagInterface $parameterBag;

    public function getConfigurationNamespace(): string
    {
        $conf = Configuration::get('configuration_namespace', $this->parameterBag);

        return \is_string($conf) ? $conf : throw new \InvalidArgumentException('Configuration "configuration_namespace" must be of type string.');
    }

    public function getConfigurationPath(): string
    {
        $conf = Configuration::get('configuration_path', $this->parameterBag);

        return \is_string($conf) ? $conf : throw new \InvalidArgumentException('Configuration "configuration_path" must be of type string.');
    }
}

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

        if (!\is_string($conf)) {
            throw new \InvalidArgumentException('Configuration "configuration_namespace" must be of type string.');
        }

        return $conf;
    }

    public function getConfigurationPath(): string
    {
        $conf = Configuration::get('configuration_path', $this->parameterBag);

        if (!\is_string($conf)) {
            throw new \InvalidArgumentException('Configuration "configuration_namespace" must be of type string.');
        }

        return $conf;
    }
}

<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Resources\Stub;

use RichCongress\WebTestBundle\OverrideService\OverrideServiceInterface;
use RichCongress\WebTestBundle\OverrideService\OverrideServiceTrait;
use RichId\ConfigurationBundle\Infrastructure\Adapter\ConfigurationAdapter;

class ConfigurationAdapterStub extends ConfigurationAdapter implements OverrideServiceInterface
{
    use OverrideServiceTrait;

    /** @var string|array<string> */
    public static $overridenServices = ConfigurationAdapter::class;

    private ?string $configurationNamespace = null;
    private ?string $configurationPath = null;
    private ?string $configurationTemplatePath = null;

    public function getConfigurationNamespace(): string
    {
        if ($this->configurationNamespace !== null) {
            return $this->configurationNamespace;
        }

        return $this->innerService->getConfigurationNamespace();
    }

    public function getConfigurationPath(): string
    {
        if ($this->configurationPath !== null) {
            return $this->configurationPath;
        }

        return $this->innerService->getConfigurationPath();
    }

    public function getConfigurationTemplatePath(): ?string
    {
        return $this->configurationTemplatePath;
    }

    public function setConfigurationNamespace(?string $configurationNamespace): self
    {
        $this->configurationNamespace = $configurationNamespace;

        return $this;
    }

    public function setConfigurationPath(?string $configurationPath): self
    {
        $this->configurationPath = $configurationPath;

        return $this;
    }

    public function setConfigurationTemplatePath(?string $configurationTemplatePath): self
    {
        $this->configurationTemplatePath = $configurationTemplatePath;

        return $this;
    }
}

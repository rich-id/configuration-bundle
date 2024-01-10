<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Port;

interface ConfigurationInterface
{
    public function getConfigurationNamespace(): string;

    public function getConfigurationPath(): string;

    public function getConfigurationTemplatePath(): ?string;
}

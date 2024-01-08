<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Configuration;

interface ConfigurationInterface
{
    public function loadConfiguration(): bool;
}

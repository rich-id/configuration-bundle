<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Configuration;

abstract class AbstractConfiguration implements ConfigurationInterface
{
    abstract protected function execute(): void;

    public function loadConfiguration(): bool
    {
        if (!$this->checkIsConcerned()) {
            return false;
        }

        $this->execute();

        return true;
    }

    protected function checkIsConcerned(): bool
    {
        return true;
    }
}

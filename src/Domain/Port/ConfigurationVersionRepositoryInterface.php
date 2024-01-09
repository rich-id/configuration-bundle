<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Port;

interface ConfigurationVersionRepositoryInterface
{
    /** @return string[] */
    public function findAllVersions(): array;
}

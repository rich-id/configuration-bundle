<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Infrastructure\Adapter;

use RichId\ConfigurationBundle\Domain\Port\ConfigurationVersionRepositoryInterface;
use RichId\ConfigurationBundle\Infrastructure\Repository\ConfigurationVersionRepository;
use Symfony\Contracts\Service\Attribute\Required;

class ConfigurationVersionRepositoryAdapter implements ConfigurationVersionRepositoryInterface
{
    #[Required]
    public ConfigurationVersionRepository $configurationVersionRepository;

    public function findAllVersions(): array
    {
        return $this->configurationVersionRepository->findAllVersions();
    }
}

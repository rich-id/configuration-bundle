<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Configuration;

use Doctrine\ORM\EntityManagerInterface;
use RichId\ConfigurationBundle\Domain\Factory\ConfigurationVersionFactory;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Service\Attribute\Required;

final class ConfigurationManager
{
    #[Required]
    public ConfigurationVersionFactory $configurationVersionFactory;

    #[Required]
    public EntityManagerInterface $entityManager;

    /** @var ConfigurationInterface[] */
    private array $configurations = [];

    public function addService(ConfigurationInterface $configuration): void
    {
        $this->configurations[] = $configuration;
    }

    public function loadAllConfiguration(?OutputInterface $output = null): void
    {
        foreach ($this->configurations as $configuration) {
            $this->loadConfiguration($configuration);
        }
    }

    public function loadConfiguration(ConfigurationInterface $configuration, ?OutputInterface $output = null): bool
    {
        $isExecuted = $configuration->loadConfiguration();

        if (!$isExecuted) {
            return false;
        }
        // todo display output

        ($this->configurationVersionFactory)($configuration::class);
        $this->entityManager->flush();

        return true;
    }
}
